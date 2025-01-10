<?php

namespace rollun\utils\Factory;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;

/**
 * Class AbstractServiceAbstractFactory
 * @package rollun\utils\Factory
 */
class AbstractServiceAbstractFactory extends AbstractAbstractFactory
{
    const KEY = AbstractServiceAbstractFactory::class;

    /**
     * service dependencies
     */
    const KEY_DEPENDENCIES = "dependencies";

    const TYPE_SERVICE = "service";

    const TYPE_SERVICES_LIST = "services_list";

    const TYPE_SERVICES_LIST_WITH_KEY = "services_list_with_key";

    const TYPE_SIMPLE = "simple";

    const KEY_VALUE_EXPAND = 'value_expand';

    const KEY_VALUE = "value";

    const KEY_TYPE = "type";

    const KEY_WITH_SERVICE_NAME = 'with_service_name';

    const DEFAULT_SERVICE_NAME_PARAM = 'name';

    /**
     * Create an object
     *
     * AbstractServiceAbstractFactory::KEY => [
     *      "myService" => [
     *          "class" => MyClass::class,
     *          "with_service_name" => true, //Sent service name `myService` to construct param with name `name` (by default)
     *          "dependencies" => [
     *              "isCreate" => true, //bool - simple by default,
     *              "age" => 123 // numeric - simple by default,
     *              "generator" => "myGenerator"// string - service by default,
     *              "name" => [ // need set up, because string is service by default, but expected string value
     *                  "type" => "simple",
     *                  "value" => "my name",
     *              ],
     *              "data" => [ // need set up, because expected array value
     *                  "type" => "simple",
     *                  "value" => [
     *                       "my name1",
     *                       "my name2",
     *                       "my name3",
     *                  ],
     *              ], "data" => [ // need set up, because expected array value
     *                  "type" => "services_list",
     *                  "value" => [
     *                       "my_service1",
     *                       "my_service2",
     *                       "my_service3",
     *                  ],
     *              ],
     *          ],
     *      ]
     *
     * ]
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerExceptionInterface if any other error occurs
     * @throws \ReflectionException
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $serviceConfig = $options ?? $this->getServiceConfig($container, $requestedName);

        $class = isset($serviceConfig[static::KEY_CLASS]) ? $serviceConfig[static::KEY_CLASS] : $requestedName;
        if (!class_exists($class)) {
            throw new ServiceNotCreatedException("Class $class not existed.");
        }
        $dependencies = isset($serviceConfig[static::KEY_DEPENDENCIES]) ? $serviceConfig[static::KEY_DEPENDENCIES] : $serviceConfig;

        $serviceDependencies = [];
        foreach ($dependencies as $parameterName => $dependency) {
            $serviceDependencies[$parameterName] = $this->resolveDependency($container, $dependency);
        }

        //Setup service name
        $withServiceName = $serviceConfig[self::KEY_WITH_SERVICE_NAME] ?? false;
        $serviceNameField = is_bool($withServiceName) ? self::DEFAULT_SERVICE_NAME_PARAM : $withServiceName;
        if ($withServiceName && !isset($serviceDependencies[$serviceNameField])) {
            $serviceDependencies[$serviceNameField] = $requestedName;
        }

        $classReflection = new ReflectionClass($class);
        $constructor = $classReflection->getConstructor();
        $paramArgs = [];
        if ($constructor) {
            $constructParameters = $constructor->getParameters();
            foreach ($constructParameters as $constructParameter) {
                if (isset($serviceDependencies[$constructParameter->getName()])) {
                    $value = $serviceDependencies[$constructParameter->getName()];
                } elseif ($constructParameter->isDefaultValueAvailable()) {
                    $value = $constructParameter->getDefaultValue();
                } else {
                    throw new ServiceNotCreatedException("Not set service $requestedName dependency {$constructParameter->getName()}.");
                }
                if ($dependencies[$constructParameter->getName()][self::KEY_VALUE_EXPAND] ?? false) {
                    /** @noinspection SlowArrayOperationsInLoopInspection */
                    $paramArgs = array_merge($paramArgs, $value);
                } else {
                    $paramArgs[] = $value;
                }
            }
        }

        return $classReflection->newInstance(...$paramArgs);
    }

    /**
     * Can the factory create an instance for the service?
     * @param ContainerInterface $container
     * @param string $requestedName
     * @return bool
     */
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        $config = $container->get("config");
        return (
            isset($config[static::KEY][$requestedName])
            && (
                class_exists($requestedName)
                || (
                    isset($config[static::KEY][$requestedName][static::KEY_CLASS])
                    && class_exists($config[static::KEY][$requestedName][static::KEY_CLASS])
                )
            )
        );

    }

    /**
     * @param $dependency
     * @param ContainerInterface $container
     * @return mixed
     */
    protected function resolveDependency(ContainerInterface $container, $dependency)
    {
        switch (true) {
            case is_array($dependency):
                switch ($dependency[static::KEY_TYPE]) {
                    case static::TYPE_SERVICES_LIST:
                        return array_map(function ($dependency) use ($container) {
                            return $container->get($dependency);
                        }, $dependency[static::KEY_VALUE]);
                    case static::TYPE_SERVICES_LIST_WITH_KEY:
                        $deps = array_map(function ($key, $dependency) use ($container) {
                            return ['key' => $key, 'dep' => $container->get($dependency)];
                        }, array_keys($dependency[static::KEY_VALUE]), array_values($dependency[static::KEY_VALUE]));
                        return array_combine(array_column($deps, 'key'), array_column($deps, 'dep'));
                    case static::TYPE_SERVICE:
                        return $container->get($dependency[static::KEY_VALUE]);
                    case static::TYPE_SIMPLE:
                        return $dependency[static::KEY_VALUE];
                    default:
                        throw new ServiceNotCreatedException("Dependency type dosn't set.");
                }
                break;
            case is_string($dependency):
                return $container->get($dependency);
                break;
            case is_null($dependency):
            case is_int($dependency):
            case is_float($dependency):
            case is_bool($dependency):
            case is_object($dependency):
                return $dependency;
                break;
            default:
                throw new ServiceNotCreatedException("Dependency has invalid type.");
        }
    }
}
