<?php

namespace Fruitware\Insurance\Model\Type;

interface VehicleCascoInterface implements VehicleInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return boolean
     */
    public function canBeWithoutFranchise();

    /**
     * @return float
     */
    public function getFranchisePercent();

    /**
     * @return array
     */
    public function getRanges();

    /**
     * @return null|string
     */
    public function getRangeFieldName();

    /**
     * @return null|string
     */
    public function getRangeUnits();

    /**
     * @param array $data
     *
     * @return TypeInterface
     */
    public function setData(array $data);

    /**
     * @return array
     */
    public function getData();
}
