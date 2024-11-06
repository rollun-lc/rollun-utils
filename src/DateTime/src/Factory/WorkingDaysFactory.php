<?php

namespace rollun\utils\DateTime\Factory;

use Psr\Container\ContainerInterface;
use rollun\utils\DateTime\WorkingDays;
use laminas\ServiceManager\Factory\FactoryInterface;

class WorkingDaysFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): WorkingDays
    {
        $config = $container->get('config')['workingDays'] ?? [];

        $weekends = $config['weekendDays'] ?? [6, 7];

        return new WorkingDays($weekends);
    }
}