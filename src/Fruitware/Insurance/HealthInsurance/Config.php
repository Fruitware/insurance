<?php

namespace Fruitware\Insurance\HealthInsurance;

use Fruitware\Insurance\Model\Casco\ConfigInterface;

class Config implements ConfigInterface
{
    protected $periods = array();
    protected $options = array();

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }    /**
     * @param  array  $periods
     *
     * @return $this
     */
    public function setPeriods(array $periods)
    {
        $this->periods = $periods;

        return $this;
    }

    /**
     * @param  array  $options
     *
     * @return $this
     **/
    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }    /**
     * @return array
     */
    public function getPeriods()
    {
        return $this->periods;
    }




}