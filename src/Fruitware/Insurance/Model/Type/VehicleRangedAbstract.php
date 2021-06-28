<?php

namespace Fruitware\Insurance\Model\Type;

abstract class VehicleRangedAbstract extends VehicleAbstract implements VehicleRangedInterface
{

    /**
     * @var int|float|string
     */
    protected $min = 12;

    /**
     * @var int|float|string
     */
    protected $max;

    /**
     * @var string
     */
    protected $units;

    /**
     * @return int|float|string
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * @return int|float|string
     */
    public function setMin()
    {
        return $this->min;
    }

    /**
     * @return int|float|string
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        $common_description = $this->description;
        $range_description = '';
        if (!empty($this->min) && !empty($this->max)) {
            $range_description = sprintf('%d &mdash; %d', $this->min, $this->max);
        } else {
            $limit = false;
            if (!empty($this->min)) {
                $odds = '&ge;';
                $limit = $this->min;
            } elseif (!empty($this->max)) {
                $odds = '<';
                $limit = $this->max;
            }

            if ($limit && isset($odds)) {
                $range_description = sprintf('%s %d',
                  $odds,
                  $limit);
            }
        }

        if ($range_description) {
            $common_description = sprintf('%s %s %s', $common_description, $range_description, $this->units);
        }

        return $common_description;
    }

    /**
     * @return float[]
     */
    public function getRange()
    {
        return array($this->min, $this->max);
    }

    /**
     * @return string
     */
    public function getRangeUnits()
    {
        return $this->units;
    }

}