<?php

namespace Fruitware\Insurance\GreenCard\Type;

use Fruitware\Insurance\Model\Casco\Type\TypeInterface;

class TruckType implements TypeInterface
{
    /**
     * @var array
     */
    protected $data = array();

    /**
     * @return string
     */
    public function getName()
    {
        return 'truck';
    }

    public function canBeWithoutFranchise()
    {
        return false;
    }

    /**
     * @return float
     */
    public function getFranchisePercent()
    {
        return 10.0;
    }

    /**
     * @return null|string
     */
    public function getRangeFieldName()
    {
        return 'weight';
    }

    /**
     * @return null|string
     */
    public function getRangeUnits()
    {
        return 'kg';
    }

    /**
     * @return array
     */
    public function getRanges()
    {
        $weights = array(
          array(0, 1999),
          array(2000, 100000),
        );

        $ranges = array();
        foreach ( $weights as $weight ) {
            $ranges[] = array(
              'from' => $weight[0],
              'to' => $weight[1]
            );
        }

        return $ranges;
    }

    /**
     * @param  array  $data
     *
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}