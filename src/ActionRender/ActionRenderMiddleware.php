<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24.01.17
 * Time: 11:58
 */

namespace rollun\utils\ActionRender;

use Zend\Stratigility\MiddlewareInterface;
use Zend\Stratigility\MiddlewarePipe;

class ActionRenderMiddleware extends MiddlewarePipe implements ActionRenderInterface
{
    /**
     * MainPipe constructor.
     * @param MiddlewareInterface $action
     * @param MiddlewareInterface $renderer
     * @internal param $middlewares
     */
    public function __construct(MiddlewareInterface $action, MiddlewareInterface $renderer)
    {
        parent::__construct();
        $this->pipe($action);
        $this->pipe($renderer);
    }
}
