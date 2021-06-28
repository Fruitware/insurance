<?php

namespace Fruitware\Insurance\Model\Casco;

interface ConfigInterface
{
    /**
     * @param  array  $periods
     *
     * @return ConfigInterface
     */
    public function setPeriods(array $periods);

    /**
     * @return array
     */
    public function getPeriods();
}