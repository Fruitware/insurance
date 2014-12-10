<?php

namespace Fruitware\Insurance\Model\Type;

use \Fruitware\Insurance\Model\Type\Exception\UndefinedVehiclePropertyException;

abstract class VehicleAbstract implements VehicleInterface {
    /**
     * @var array
     */
    protected $data = array();

    /**
     * @var string
     */
    protected $name;

	/**
	 * @var string
	 */
	protected $alias;

    /**
     * @var string
     */
    protected $description;

	/**
	 * @param array $properties
	 *
	 * @throw UndefinedVehiclePropertyException;
	 **/
	public function __construct(array $properties)
	{
		foreach ($properties as $property=>$value) {
			if ( ! property_exists($this, $property)) {
				throw new UndefinedVehiclePropertyException(sprintf('Cant set property "%s"', $property));
			};
			$this->$property = $value;
		};
	}

    /**
     * @return string
     */
    public function getName()
	{
		return $this->name;
	}

    /**
     * @return string
     */
    public function getAlias()
	{
		return $this->alias;
	}

    /**
     * @return string
     */
    public function getDescription()
	{
		return $this->description;
	}

    /**
     * @param array $data
	 * @param bool $reveal_data
     *
     * @return VehicleInterface
     */
    public function setData(array $data, $poor_data=true)
	{
		if ( ! $poor_data) {
			$name = $this->getName();
			$alias = $this->getAlias();

			$data = (array)@$data[$name][$alias];
		};

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
