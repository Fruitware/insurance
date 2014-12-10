<?php

namespace Fruitware\Insurance\GreenCard;

use \Fruitware\Insurance\Model\InsuranceAbstract;

class GreenCard extends InsuranceAbstract
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
	function setPeriods($periods)
	{
		$titled_periods = array();
		foreach ($periods as $period_id)
			$titled_periods[$period_id] = sprintf('%d %s', substr($period_id, 1), $period_id[0]=='m'?'month':'day');

		$this->config->setPeriods($titled_periods);

		return $this;
	}
	
}