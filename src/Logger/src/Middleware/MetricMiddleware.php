<?php

namespace rollun\logger\Middleware;

use rollun\dic\InsideConstruct;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

/**
 * Class MetricMiddleware
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
class MetricMiddleware implements MiddlewareInterface
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * MetricMiddleware constructor.
     *
     * @param LoggerInterface|null $logger
     *
     * @throws \ReflectionException
     */
    public function __construct(LoggerInterface $logger = null)
    {
        InsideConstruct::setConstructParams(['logger' => LoggerInterface::class]);
    }

    /**
     * @inheritDoc
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->getUri()->getPath() == '/api/webhook/cron' && $request->getMethod() == 'GET') {
            $this->logger->notice('METRICS', ['metricId' => 'webhook_cron_get', 'value' => 1]);
        }

        return $handler->handle($request);
    }
}
