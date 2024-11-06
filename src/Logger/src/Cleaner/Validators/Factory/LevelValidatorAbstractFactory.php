<?php

namespace rollun\logger\Cleaner\Validators;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use rollun\utils\Cleaner\CleaningValidator\Factory\AbstractCleaningValidatorAbstractFactory;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;

class LevelValidatorAbstractFactory extends AbstractCleaningValidatorAbstractFactory
{
    const DEFAULT_CLASS = LevelValidator::class;

    const KEY_LEVEL = "level";

    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerExceptionInterface if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $serviceFactory = $this->getServiceConfig($container,  $requestedName);

        return new LevelValidator($serviceFactory[static::KEY_LEVEL]);
    }
}