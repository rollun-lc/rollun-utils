<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 23.01.17
 * Time: 17:52
 */

namespace rollun\utils\MainPipe;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class ResponseReturnerFactory implements FactoryInterface
{

    const KEY_RESPONSE_RETURNER = 'responseReturner';

    const KEY_ACCEPT_TYPE_PATTERN = 'acceptTypesPattern';

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
        $dynamicResponseReturner = function (Request $request,Response $response, callable $next = null) use ($container) {
            $accept = $request->getHeaderLine('Accept');
            $config = $container->get('config');
            $config = isset($config[static::KEY_RESPONSE_RETURNER]) ? $config[static::KEY_RESPONSE_RETURNER] : null;
            if(!isset($config)) {
                throw new \Exception("ResponseReturner config not found");
            }
            foreach ($config[static::KEY_ACCEPT_TYPE_PATTERN] as $acceptTypePattern => $responseMiddleware) {
                if (preg_match($acceptTypePattern, $accept)) {
                    if(!$container->has($responseMiddleware)) {
                        throw new ServiceNotFoundException("$responseMiddleware not found!");
                    }
                    $responseMiddleware = $container->get($responseMiddleware);
                    return $responseMiddleware($request, $response, $next);
                }
            }
            throw new ServiceNotFoundException("ResponseReturner not found!");
        };
        return $dynamicResponseReturner;
    }
}
