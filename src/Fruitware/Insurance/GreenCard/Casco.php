<?php

namespace Fruitware\Insurance\GreenCard;

use Fruitware\Insurance\Casco\Type\BusType;
use Fruitware\Insurance\Casco\Type\CarType;
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
     * @param  Config  $config
     */
    public function __construct(Config $config)
    {
        parent::__construct($config);
        $this->config = $config;
    }

    public function getCarType()
    {
        return new CarType();
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