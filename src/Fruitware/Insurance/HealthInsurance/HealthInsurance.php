<?php

namespace Fruitware\Insurance\HealthInsurance;

use \Exception;
use \DateTime;

use \Fruitware\Insurance\Model\InsuranceAbstract;
use Fruitware\Insurance\Model\Type\VehicleInterface;

class HealthInsurance extends InsuranceAbstract
{
    /**
     * @var Config
     */
    protected $config;

	/**
	 * @param array $periods
	 *
	 * @return InsuranceAbstract
	 */
	public function setPeriods($periods)
	{
		$this->config->setPeriods($periods);

		return $this;
	}

	/**
	 * @param array $options
	 *
	 * @return $this
	 */
	public function setOptions(array $options)
	{
		$this->config->setOptions($options);

		return $this;
	}

	/**
	 * @param string $alias Code of a country
	 *
	 * @return null|VehicleInterface Instance of country type
	 */
	public function getByAlias($alias)
	{
		$vehicle = null;

		foreach ($this->getGroups() as $group) {
			foreach ($group as $instance)
				if ($instance->getAlias() == $alias) {
					$vehicle = $instance;
					break 2;
				};
		};

		return $vehicle;
	}

    /**
     * Calculations specific for HealthInsurance, for single person
     *
	 * @param int $age Persons age
	 * @param string $alias Code of country
     * @param int $days Number of days of insurance
     * @param float $per_day Amount of payment per days insurance
	 * @param bool $is_work Physical work during insurance
	 * @param bool $is_sport Participate in sport competitions during insurance
	 * @param bool $is_skiing Skiing during insurance
     *
     * @return float Insurance price for one person
     * @throw Exception free-text exceptions, doesnt specify type of error, just it occurrence
     */
	public function calculateSinglePerson($age, $alias, $amount, $days, $per_day, $is_work, $is_sport, $is_skiing)
	{
		$payment = $days * $per_day;

		if ($amount <= 15000 && $payment < 2)
			$payment = 2;
		if ($amount >= 30000 && $payment < 3)
			$payment = 3;

		if (65 <= $age && $age <= 69)
			$payment *= 1.75;
		elseif (70 <= $age && $age <= 74)
			$payment *= 2.25;
		elseif ($age <= 15)
			$payment *= 0.8;

		if ($is_work)
			$payment *= 2.5;
		if ($is_sport)
			$payment *= 2.1;
		if ($is_skiing)
			$payment *= 1.75;

		if ($alias == 'RO')
			$payment *= 0.65;

		return $payment;
	}

   /**
     * Calculations specific for , for a group of people
     *
     * @param array $persons List of person ages
     * @param string $alias Code of host country
     * @param DateTime $from Start date of period
     * @param DateTime $to End date of preiod
	 * @param bool $is_work Physical work during insurance
	 * @param bool $is_sport Participate in sport competitions during insurance
	 * @param bool $is_skiing Skiing during insurance
     *
     * @return float Full insurance price for all persons
     * @throw Exception free-text exceptions, doesnt specify type of error, just it occurrence
     */
	public function calculate(array $persons, $alias, $amount, $from, $to, $is_work, $is_sport, $is_skiing)
	{
		$date_diff = $from->diff($to);
		$total_days = (int)$date_diff->days;

		foreach ($this->getPeriods() as $idx=>$period) {
			if ($period[0] <= $total_days && $total_days <= $period[1]) {
				$period_idx = $idx;
				break;
			};
		};

		if ( ! isset($period_idx))
			throw new Exception('Insurance period is out of allowed period');

		$data = $this->getByAlias($alias)
			->getData();

		if ($amount != $data['limit'])
			throw new Exception('Wrong amount');

		$per_day = @$data['prices'][$period_idx];
		if ( ! $per_day)
			throw new Exception('Payment amount for selected period is undefined');

		$total = 0;

		$today = new DateTime();
		foreach ($persons as $person) {
			$age = $today->diff($person['birthday'])->y;
			$total += $this->calculateSinglePerson(
				$age,
				$alias,
				(int)$amount,
				$total_days,
				(float)$per_day,
				$is_work,
				$is_sport,
				$is_skiing
				);
		};

		return (float)$total;
	}

}
