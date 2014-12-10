<?php

namespace Fruitware\Insurance\Model\Type;

interface VehicleRangedInterface extends VehicleInterface
{
    /**
     * @return float[]
     */
	public function getRange();

    /**
     * @return range
     */
	public function getRangeUnits();
}
