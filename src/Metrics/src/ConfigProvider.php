<?php

namespace rollun\utils\Metrics;

use rollun\utils\Metrics\Callback\ClearOldProcessesDataCallback;
use rollun\utils\Metrics\Factory\MetricsMiddlewareFactory;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            MetricsMiddlewareFactory::KEY => [
                MetricsMiddleware::class => [
                    MetricsMiddlewareFactory::KEY_METRIC_PROVIDERS => [
                        ProcessTracker::class,
                    ],
                ],
            ],
        ];
    }

    public function getDependencies(): array
    {
        return [
            'aliases' => [
                ProcessTrackerInterface::class => ProcessTracker::class,
            ],
            'invokables' => [
                ClearOldProcessesDataCallback::class => ClearOldProcessesDataCallback::class,
                ProcessTracker::class => ProcessTracker::class,
            ],
            'factories' => [
                MetricsMiddleware::class => MetricsMiddlewareFactory::class,
            ],
        ];
    }
}
