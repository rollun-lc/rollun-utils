<?php


namespace rollun\logger\Cleaner\Validators\Factory;


use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use rollun\logger\Cleaner\Validators\ExpireTimeValidator;
use rollun\utils\Cleaner\CleaningValidator\Factory\AbstractCleaningValidatorAbstractFactory;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;

class ExpireTimeValidatorAbstractFactory extends AbstractCleaningValidatorAbstractFactory
{
    const DEFAULT_CLASS = ExpireTimeValidator::class;

    const KEY_SECOND_TO_EXPIRE = "secondToExpire";

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
        $serviceConfig = $this->getServiceConfig($container, $requestedName);

        return new ExpireTimeValidator($serviceConfig[static::KEY_SECOND_TO_EXPIRE]);
    }
}