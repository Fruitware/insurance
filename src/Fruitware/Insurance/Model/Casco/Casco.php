<?php

namespace Fruitware\Insurance\Model\Casco;

use Fruitware\Insurance\Model\Casco\Type\Exception\UndefinedTypeException;
use Fruitware\Insurance\Model\Casco\Type\TypeInterface;

abstract class Casco implements CascoInterface
{
    /**
     * @var ConfigInterface
     */
    protected $config;

    /**
     * @var array
     */
    protected $types = array();

    /**
     * @param ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * @return array
     */
    public function getPeriods()
    {
        $periods = array();

        $from = new \DateTime();

        foreach ($this->config->getPeriods() as $years) {
            $to = new \DateTime();

            $periods[] = array(
                'from' => $from->format('Y'),
                'to'   => $to->modify(sprintf('-%s years', $years))->format('Y')
            );

            $from = clone $to->modify('-1 year');
        }

        return $periods;
    }

    /**
     * @param TypeInterface $type
     *
     * @return $this
     */
    public function setType(TypeInterface $type)
    {
        $this->types[$type->getName()] = $type;

        return $this;
    }

    /**
     * @return TypeInterface[]
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * @param string $name
     *
     * @return TypeInterface
     *
     * @throw UndefinedTypeException
     */
    public function getType($name)
    {
        /**
         * @var TypeInterface $type
         */
        $type = $this->types[$name];

        if (!$type instanceof TypeInterface) {
            throw new UndefinedTypeException(sprintf('undefined type %s', $name));
        }

        return $type;
    }
}