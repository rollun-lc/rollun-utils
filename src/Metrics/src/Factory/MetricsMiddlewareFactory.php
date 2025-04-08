<?php

namespace rollun\utils\Metrics\Factory;

use Laminas\ServiceManager\Factory\AbstractFactoryInterface;
use Psr\Container\ContainerInterface;
use rollun\utils\Metrics\MetricsProviderInterface;
use rollun\utils\Metrics\MetricsMiddleware;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Factory\FactoryInterface;

class MetricsMiddlewareFactory implements AbstractFactoryInterface
{
    const KEY = self::class;

    const DEFAULT_CLASS = MetricsMiddleware::class;

    const KEY_METRIC_PROVIDERS = 'metricProviders';

    public function canCreate(ContainerInterface $container, $requestedName)
    {
        $config = $container->get('config')[static::KEY] ?? [];

        if (empty($config[$requestedName])) {
            return false;
        }

        return true;
    }

    /**
     * @param string $requestedName
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get("config");

        try {
            $serviceConfig = $config[static::KEY][$requestedName];
        } catch (\Throwable) {
            throw new ServiceNotCreatedException("Missing config for '$requestedName' service");
        }

        $metricProvidersField = static::KEY_METRIC_PROVIDERS;

        if (!isset($serviceConfig[static::KEY_METRIC_PROVIDERS])) {
            throw new ServiceNotCreatedException("Dependency '$metricProvidersField' is not set in config");
        }

        $metricProviderClasses = $serviceConfig[static::KEY_METRIC_PROVIDERS];

        $metricProviders = [];

        foreach ($metricProviderClasses as $metricProviderClass) {
            $metricProvider = $container->get($metricProviderClass);
            if (!$metricProvider instanceof MetricsProviderInterface) {
                throw new ServiceNotCreatedException("Dependency '$metricProvidersField' contains object that is not implementing required interface");
            }
            $metricProviders[] = $metricProvider;
        }

        $class = static::DEFAULT_CLASS;

        return new $class($metricProviders);
    }
}
