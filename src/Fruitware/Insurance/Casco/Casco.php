<?php

namespace Fruitware\Insurance\Casco;

use Fruitware\Insurance\Casco\Type\AutoTurismType;
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

    public function getAutoTurismType()
    {
        return new AutoTurismType();
    }
}