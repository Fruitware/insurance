<?php

namespace Fruitware\Insurance\Model\Type;

interface VehicleInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @param array $data
	 * @param bool $poor_data
     *
     * @return TypeInterface
     */
    public function setData(array $data, $poor_data=false);

    /**
     * @return array
     */
    public function getData();
}
