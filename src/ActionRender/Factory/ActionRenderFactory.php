<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24.01.17
 * Time: 12:03
 */

namespace rollun\utils\ActionRender\Factory;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use rollun\utils\ActionRender\ActionRenderInterface;
use rollun\utils\ActionRender\ActionRenderMiddleware;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\AbstractFactoryInterface;

class ActionRenderFactory implements AbstractFactoryInterface
{
    const KEY_ACTION_RENDER = 'ActionRender';

    const KEY_AR_MIDDLEWARE = 'ARMiddleware';

    const KEY_ACTION = 'Action';

    const KEY_RENDER = 'Render';


    /**
     * Can the factory create an instance for the service?
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @return bool
     */
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        $config = $container->get('config');
        if (isset($config[static::KEY_ACTION_RENDER][$requestedName][static::KEY_AR_MIDDLEWARE])) {
            $middleware = $config[static::KEY_ACTION_RENDER][$requestedName][static::KEY_AR_MIDDLEWARE];
            if (is_array($middleware)) {
                return (isset($middleware[static::KEY_ACTION]) && isset($middleware[static::KEY_RENDER]));
            }
            return true;
        }
        return false;
    }

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
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('config');

        $middleware = $config[static::KEY_ACTION_RENDER][$requestedName][static::KEY_AR_MIDDLEWARE];
        if (is_array($middleware)) {
            $action = $middleware[static::KEY_ACTION];
            $render = $middleware[static::KEY_RENDER];
            if ($container->has($action) && $container->has($render)) {
                return new ActionRenderMiddleware($container->get($action), $container->get($render));
            }
        } else if ($container->has($middleware)){
            //TODO: Add Interface ActionReturn.
            $middleware = $container->get($middleware);
            if ($middleware instanceof ActionRenderInterface){
                return $middleware;
            }
            throw new ServiceNotCreatedException("$middleware not implement ActionRenderInterface");
        }
        throw new ServiceNotCreatedException("Not get $middleware for service");
    }
}
