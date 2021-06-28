<?php

namespace Fruitware\Insurance\GreenCard;

use DateTime;
use Exception;
use Fruitware\Insurance\Model\InsuranceAbstract;
use Fruitware\Insurance\Model\Type\VehicleInterface;

class GreenCard extends InsuranceAbstract
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @param  array  $periods
     *
     * @return InsuranceAbstract
     */
    function setPeriods($periods)
    {
        $titled_periods = array();
        foreach ( $periods as $period_id ) {
            $titled_periods[$period_id] = sprintf('%d %s', substr($period_id, 1), $period_id[0] == 'm' ? 'month' : 'day');
        }

        $this->config->setPeriods($titled_periods);

        return $this;
    }

    /**
     * Calculations specific for Casco, for single vehicle
     *
     * @param  string  $alias  Name of vehicle sub-type
     * @param  DateTime  $from  Start date of period
     * @param  DateTime  $to  End date of preiod
     *
     * @return float Payment for one vehicle
     * @throws Exception
     * @throw Exception free-text exceptions, doesnt specify type of error, just it occurrence
     */
    public function calculate($alias, DateTime $from, DateTime $to)
    {
        if (!$from || !$to) {
            throw new Exception('Invalid date entity');
        } elseif ($from > $to) {
            throw new Exception('Wrong date order');
        }

        $date_diff = $from->diff($to);

        $years = (int) $date_diff->y;

        $month = (int) $date_diff->m + ($years * 12);
        $days = (int) $date_diff->d;

        $hash = sprintf('%02d%02d', $month, $days);
        foreach ( $this->getPeriods() as $idx => $period ) {
            preg_match('/^(?:m(?P<month>[1-9][0-9]*))?(?:d(?P<days>[1-9][0-9]*))?$/', $idx, $match);
            $period_str = sprintf('%02d%02d', (int) @$match['month'], (int) @$match['days']);

            if ($hash <= $period_str) {
                $period_idx = $idx;
                break;
            }
        }

        if (!isset($period_idx)) {
            throw new Exception('Date is beyound the limits');
        }

        $data = $this->getByAlias($alias)->getData();
        $per_day = @$data[$period_idx] ?: null;

        if (!isset($per_day)) {
            throw new Exception('No payments specified for this period');
        }

        return (float) ($per_day);
    }

    /**
     * @param  string  $alias  Name of vehicle sub-type
     *
     * @return null|VehicleInterface Instance of vehicle type
     */
    public function getByAlias($alias)
    {
        $vehicle = null;

        foreach ( $this->getGroups() as $group ) {
            foreach ( $group as $instance ) {
                if ($instance->getAlias() == $alias) {
                    $vehicle = $instance;
                    break 2;
                }
            }
        }

        return $vehicle;
    }

}