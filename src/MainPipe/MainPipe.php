<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 23.01.17
 * Time: 15:26
 */

namespace rollun\utils\MainPipe;

use Zend\Stratigility\MiddlewarePipe;

class MainPipe extends MiddlewarePipe
{
    /**
     * MainPipe constructor.
     * @param $middlewares
     */
    public function __construct(array $middlewares)
    {
        parent::__construct();
        foreach ($middlewares as $middleware) {
            $this->pipe($middleware);
        }
    }
}
