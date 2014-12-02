<?php

namespace Fruitware\Insurance\Casco\Type;

use Fruitware\Insurance\Model\Casco\Type\TypeInterface;

class AutoTurismType implements TypeInterface
{
    /**
     * @var array
     */
    protected $data = array();

    public function canBeWithoutFranchise()
    {
        return true;
    }

    /**
     * @return float
     */
    public function getFranchisePercent()
    {
        return 5.0;
    }

    /**
     * @return null|string
     */
    public function getRangeFieldName()
    {
        return 'price';
    }

    /**
     * @return array
     */
    public function getRanges()
    {
        $prices = array(25000, 75000, 100000, 150000);

        $ranges = array();

        $from = 0;
        foreach ($prices as $key => $price) {
            $to = $price;

            $ranges[] = array(
                'from' => $from,
                'to'   => $to
            );

            $from = $to + 1;
        }

        return $ranges;
    }

    /**
     * @param array $data
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
        return array(
            array(0, 2, 3, 4, 5),
            array(0, 2, 3, 4, 5),
        );

        return $this->data;
    }
}
