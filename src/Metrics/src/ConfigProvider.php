<?php

namespace rollun\utils\Metrics;

use rollun\utils\Metrics\Factory\MetricsMiddlewareFactory;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            MetricsMiddlewareFactory::KEY => $this->getMetricsMiddlewareConfig(),
        ];
    }

    public function getMetricsMiddlewareConfig(): array
    {
        return [
            'metrics_1min' => [
                MetricsMiddlewareFactory::KEY_METRIC_PROVIDERS => [
                ],
            ],
            'metrics_5min' => [
                MetricsMiddlewareFactory::KEY_METRIC_PROVIDERS => [
                ],
            ],
            'metrics_15min' => [
                MetricsMiddlewareFactory::KEY_METRIC_PROVIDERS => [
                ],
            ],
            'metrics_30min' => [
                MetricsMiddlewareFactory::KEY_METRIC_PROVIDERS => [
                ],
            ],
            'metrics_1hour' => [
                MetricsMiddlewareFactory::KEY_METRIC_PROVIDERS => [
                ],
            ],
            'metrics_2hour' => [
                MetricsMiddlewareFactory::KEY_METRIC_PROVIDERS => [
                ],
            ],
            'metrics_4hour' => [
                MetricsMiddlewareFactory::KEY_METRIC_PROVIDERS => [
                ],
            ],
            'metrics_12hour' => [
                MetricsMiddlewareFactory::KEY_METRIC_PROVIDERS => [
                ],
            ],
            'metrics_1day' => [
                MetricsMiddlewareFactory::KEY_METRIC_PROVIDERS => [
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
