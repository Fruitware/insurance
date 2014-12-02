<?php

namespace Fruitware\Insurance\Model\Casco;

use Fruitware\Insurance\Model\Casco\Type\TypeInterface;

interface CascoInterface
{
    /**
     * @return array
     */
    public function getPeriods();

    /**
     * @param TypeInterface $type
     *
     * @return CascoInterface
     */
    public function setType(TypeInterface $type);

    /**
     * @return TypeInterface[]
     */
    public function getTypes();

    /**
     * @param string $name
     *
     * @return TypeInterface
     *
     * @throw UndefinedTypeException
     */
    public function getType($name);
}