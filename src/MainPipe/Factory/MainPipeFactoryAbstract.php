<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 23.01.17
 * Time: 15:26
 */

namespace rollun\utils\MainPipe\Factory;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use rollun\utils\MainPipe\MainPipe;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\AbstractFactoryInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class MainPipeFactoryAbstract implements AbstractFactoryInterface
{

    const KEY_MAIN_PIPE = 'mainPipe';
    protected $middlewares;

    public function __construct(array $middlewares = [])
    {
        $this->middlewares = $middlewares;
    }

    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return object
     * @throws \Exception
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('config');
        $middlewares = $config['mainPipe'][$requestedName]['middlewares'];
        foreach ($middlewares as $key => $middleware) {
            if ($container->has($middleware)) {
                $this->middlewares[$key] = $container->get($middleware);
            }
        }

        ksort($this->middlewares);
        return new MainPipe($this->middlewares);
    }

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
        if (isset($config['mainPipe'][$requestedName]['middlewares'])) {
            return true;
        }
        return false;
    }
}
