<?php

namespace Fruitware\Insurance\Casco;

use Fruitware\Insurance\Model\Casco\ConfigInterface;

class Config implements ConfigInterface
{
    /**
     * @return array
     */
    public function getPeriods()
    {
        return array(3, 5, 7, 9, 12);
    }

    /**
     * @return array
     */
//    public function getCategories()
//    {
//        return array(
//            'autoturism' => array(
//                'filter'    => array(
//                    'field'     => 'price'
//                )
//            ),
//            'truck' => array(
//                'filter'    => array(
//                    'field'     => 'weight'
//                )
//            ),
//            'bus' => array(),
//            'truck_trailer' => array(),
//            'agriculture' => array(),
//        );
//    }
}