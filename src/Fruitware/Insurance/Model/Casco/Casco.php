<?php

namespace Fruitware\Insurance\Model\Casco;

abstract class Casco
{
    /**
     * @var ConfigInterface
     */
    protected $config;

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
}