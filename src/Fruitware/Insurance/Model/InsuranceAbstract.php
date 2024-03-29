<?php

namespace Fruitware\Insurance\Model;

use Fruitware\Insurance\Model\Casco\ConfigInterface;
use Fruitware\Insurance\Model\Type\Exception\UndefinedGroupException;
use Fruitware\Insurance\Model\Type\VehicleInterface;

abstract class InsuranceAbstract implements InsuranceInterface
{
    /**
     * @var ConfigInterface
     */
    protected $config;

    /**
     * @var array
     */
    protected $groups = array();

    /**
     * @param  ConfigInterface  $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * @param  array  $periods
     */
    abstract function setPeriods($periods);

    /**
     * @return array
     */
    public function getPeriods()
    {
        return $this->config->getPeriods();
    }

    /**
     * @param  array  $data
     *
     * @return InsuranceAbstract
     */
    public function provideData(array $data)
    {
        foreach ( $this->getGroups() as $items ) {
            foreach ( $items as $item ) {
                $item->setData($data, false);
            }
        }

        return $this;
    }    /**
     * @param  string|null  $group
     * @param  VehicleInterface  $type
     *
     * @return InsuranceInterface
     */
    public function addGroupedType($group, VehicleInterface $type)
    {
        if (empty($group) || !is_string($group)) {
            $group = '';
            if (!isset($this->groups[''])) {
                $this->groups = array('' => array()) + $this->groups;
            }
        }
        $this->groups[$group][] = $type;

        return $this;
    }

    /**
     * @return VehicleInterface[]
     */
    public function getGroups()
    {
        return $this->groups;
    }    /**
     * @param  VehicleInterface  $type
     *
     * @return InsuranceInterface
     */
    public function addType(VehicleInterface $type)
    {
        $this->addGroupedType(null, $type);

        return $this;
    }

    /**
     * @param  string|null  $group
     *
     * @return VehicleInterface[]
     *
     * @throw UndefinedTypeException
     */
    public function getGroup($group)
    {
        if (empty($group) || !is_string($group)) {
            $group = 0;
        }

        if (!isset($this->groups[$group])) {
            throw new UndefinedGroupException(sprintf('undefined group %s', $group));
        }

        return $this->groups[$group];
    }




}