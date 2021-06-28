<?php

namespace Fruitware\Insurance\Casco\Type;

use Fruitware\Insurance\Model\Casco\Type\TypeInterface;

class SemitrailerType implements TypeInterface
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
        return 'semitrailer';
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
        return;
    }

    /**
     * @return null|string
     */
    public function getRangeUnits()
    {
        return;
    }

    /**
     * @return array
     */
    public function getRanges()
    {
        return array('');
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