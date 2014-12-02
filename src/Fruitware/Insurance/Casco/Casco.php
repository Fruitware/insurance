<?php

namespace Fruitware\Insurance\Casco;

use Fruitware\Insurance\Casco\Type\AutoturismType;
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
}