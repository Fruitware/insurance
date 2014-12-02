<?php

namespace Fruitware\Insurance\Casco;

use Fruitware\Insurance\Casco\Type\AutoturismType;
use Fruitware\Insurance\Casco\Type\BusType;
use Fruitware\Insurance\Casco\Type\SemitrailerType;
use Fruitware\Insurance\Casco\Type\TruckType;
use Fruitware\Insurance\Model\Casco\Casco as BaseCasco;

class Casco extends BaseCasco
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function getAutoturismType()
    {
        return new AutoturismType();
    }

    public function getTruckType()
    {
        return new TruckType();
    }

    public function getBusType()
    {
        return new BusType();
    }

    public function getTruckTrailerType()
    {
        return new SemitrailerType();
    }
}