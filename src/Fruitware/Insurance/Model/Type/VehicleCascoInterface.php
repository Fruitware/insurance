<?php

namespace Fruitware\Insurance\Model\Type;

interface VehicleCascoInterface extends VehicleInterface {
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
     * @param  array  $data
     * @param  bool  $poor_data
     * @return VehicleInterface
     */
    public function setData(array $data, $poor_data = false);

    /**
     * @return array
     */
    public function getData();
}