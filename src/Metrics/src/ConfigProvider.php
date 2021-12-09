<?php

namespace rollun\utils\Metrics;

use rollun\utils\Metrics\Factory\MetricsMiddlewareFactory;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    public function getDependencies(): array
    {
        return [
            'factories' => [
                MetricsMiddleware::class => MetricsMiddlewareFactory::class,
            ],
        ];
    }
}
