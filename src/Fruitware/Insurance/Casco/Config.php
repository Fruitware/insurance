<?php

namespace Fruitware\Insurance\Casco;

use Fruitware\Insurance\Model\Casco\ConfigInterface;

class Config implements ConfigInterface
{
    protected $periods = array();

    /**
     * @param array $periods
     *
     * @return $this
     */
    public function setPeriods(array $periods)
    {
        $this->periods = $periods;

        return $this;
    }

    /**
     * @return array
     */
    public function getPeriods()
    {
        return $this->periods;
    }
}