<?php

namespace Fruitware\Insurance\Casco;

use Exception;
use Fruitware\Insurance\Casco\Type\BusType;
use Fruitware\Insurance\Casco\Type\CarType;
use Fruitware\Insurance\Casco\Type\SemitrailerType;
use Fruitware\Insurance\Casco\Type\TruckType;
use Fruitware\Insurance\Model\Casco\Casco as BaseCasco;

class Casco extends BaseCasco
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @param  Config  $config
     */
    public function __construct(Config $config)
    {
        parent::__construct($config);
        $this->config = $config;
    }

    public function getCarType()
    {
        return new CarType();
    }

    public function getTruckType()
    {
        return new TruckType();
    }

    public function getBusType()
    {
        return new BusType();
    }

    public function getTruckTrailerType()
    {
        return new SemitrailerType();
    }

    /**
     * Calculations specific for Casco, for multiple vehicles
     *
     * @param  array  $vehicles  List of vehicles,
     *        format: [type, price(euro), year of manufacture, exclude franchise, experience (years), drivers age, name of units, quantity of units]
     * @param  int  $country_zone  ID of country zone
     *        format: 1=Moldova, 2=Moldova+CIS, 3=Moldova+World
     *
     * @return null|float Summary payment, null if an errorc has been occurred
     */
    public function calculate($vehicles, $country_zone)
    {

        $total = 0;

        foreach ( (array) $vehicles as $vehicle ) {
            $type = (string) $vehicle['type'];
            $price = (float) $vehicle['price'];
            $year = (int) $vehicle['year'];
            $without_franchise = (bool) $vehicle['without_franchise'];
            $driving_experience = (int) $vehicle['driving_experience'];
            $drivers_age = (int) $vehicle['drivers_age'];
            $unit = isset($vehicle['unit']) ? (string) $vehicle['unit'] : null;
            $quantity = (float) $vehicle['quantity'];
            try {
                $result = $this->calculateSingle(
                  $type,
                  $price,
                  $year,
                  $without_franchise,
                  $driving_experience,
                  $drivers_age,
                  $unit,
                  $quantity
                );
            } catch (Exception $e) {
                return null;
            }

            $total += $result;
        }

        if (1 == (int) $country_zone) {
            $total *= 0.95;
        }

        $vehicles_count = count($vehicles);
        if (5 <= $vehicles_count && $vehicles_count < 10) {
            $total *= 0.93;
        } elseif (10 <= $vehicles_count) {
            $total *= 0.88;
        }

        return $total;
    }

    /**
     * Calculations specific for Casco, for single vehicle
     * @ToDo: review logic & implementation, if it's should be rewritten
     *
     * @param  string  $type  Name of vehicle type
     * @param  float  $price  Price of vehicle in euro
     * @param  int  $year  Year of vehicle manufacturing
     * @param  bool  $without_franchise  Add franchise or not
     * @param  int  $driving_experience  Expirience in driving
     * @param  int  $drivers_age  Drivers age old
     * @param  null|string  $unit  Name of unit that is used by specified type, or null if no units specified
     * @param  float  $quantity  Quantity of units
     *
     * @return float Payment for one vehicle
     * @throw Exception free-text exceptions, doesnt specify type of error, just it occurrence
     * @throws Exception
     */
    public function calculateSingle($type, $price, $year, $without_franchise, $driving_experience, $drivers_age, $unit, $quantity)
    {
        $vehicle = $this->getType($type);
        if (!$vehicle) {
            throw new Exception(sprintf('undefined type %s', $type));
        }

        $required_unit = $vehicle->getRangeUnits();
        if ($unit !== $required_unit) {
            throw new Exception(sprintf(
              'Vehicle type "%s" requires "%s" unit, "%s" was specified',
              $type,
              var_export($vehicle->getRangeUnits(), true),
              var_export($unit, true)
            ));
        }

        if (isset($unit)) {
            foreach ( $vehicle->getRanges() as $idx => $range ) {
                // Hack to rearange range bounds (originaly future->past, logicaly past->future)
                $start = (int) $range['from'];
                $end = (int) $range['to'];

                if ((empty($start) || $start <= $quantity) && (empty($end) || $end >= $quantity)) {
                    $range_idx = $idx;
                    break;
                }
            }
        } else {
            $range_idx = 0;
        }

        if (!isset($range_idx)) {
            throw new Exception(sprintf(
              'Quantity "%d" misses available ranges',
              $quantity
            ));
        }

        foreach ( $this->getPeriods() as $idx => $range ) {
            // Hack to swap range bounds (originaly future->past, logicaly past->future)
            $start = (int) $range['to'];
            $end = (int) $range['from'];

            if ($start <= $year && $year <= $end) {
                $period_idx = $idx;
                break;
            }

        }

        if (!isset($period_idx)) {
            throw new Exception(sprintf(
              'Year "%d" misses available periods',
              $year
            ));
        }

        if ($vehicle->canBeWithoutFranchise()) {
            $francize_idx = 1;
            if ($without_franchise && $drivers_age > 23 && $driving_experience > 1) {
                $francize_idx = 0;
            }

        } else {
            $francize_idx = 0;
        }

        $data = $vehicle->getData();
        $percent = @$data[$range_idx][$period_idx][$francize_idx];

        if (!isset($percent) || $percent === '') {
            throw new Exception('Percent for specified qualifiers not found');
        }

        return $price * $percent / 100;
    }
}