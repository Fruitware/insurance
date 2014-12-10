<?php

namespace Fruitware\Insurance\Model;

use Fruitware\Insurance\Model\Type\VehicleInterface;
use Fruitware\Insurance\Model\Type\Exception\UndefinedGroupException;

interface InsuranceInterface
{
    /**
     * @return array
     */
    public function getPeriods();

    /**
     * @param string|null $group
     * @param VehicleInterface $type
     *
     * @return InsuranceInterface
     */
    public function addGroupedType($group, VehicleInterface $type);

    /**
     * @param VehicleInterface $type
     *
     * @return InsuranceInterface
     */
	public function addType(VehicleInterface $type);

    /**
     * @return VehicleInterface[]
     */
    public function getGroups();

    /**
     * @param string $group
     *
     * @return VehicleInterface[]
     *
     * @throw UndefinedTypeException
     */
    public function getGroup($name);
}
