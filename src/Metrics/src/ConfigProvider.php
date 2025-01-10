<?php

namespace rollun\utils\Metrics;

use rollun\utils\Metrics\Factory\MetricsMiddlewareFactory;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            MetricsMiddlewareFactory::KEY => [
                MetricsMiddleware::class => [
                    MetricsMiddlewareFactory::KEY_METRIC_PROVIDERS => [],
                ],
            ],
        ];
    }

    public function getDependencies(): array
    {
        return [
            'abstract_factories' => [
                MetricsMiddlewareFactory::class,
            ],
        ];
    }
}
