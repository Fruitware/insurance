<?php

namespace Fruitware\Insurance\Model\Casco\Type;

interface TypeInterface
{
    /**
     * @return boolean
     */
    public function canBeWithoutFranchise();

    /**
     * @return float
     */
    public function getFranchisePercent();

    /**
     * @return array
     */
    public function getRanges();

    /**
     * @return null|string
     */
    public function getRangeFieldName();
}
