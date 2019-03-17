<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 17.03.19
 * Time: 15:19
 */

namespace rollun\tracer;


use Jaeger\Tag\StringTag;
use Jaeger\Tracer\Tracer;
use rollun\dic\InsideConstruct;
use rollun\utils\Json\Serializer;
use Zend\Http\Client;
use Zend\Http\Headers;
use Zend\Http\Request;

class ClientWithTracer extends Client
{
    public const TRACER_HEADER_NAME = 'X-Tracer-Context';
    /**
     * @var Tracer
     */
    private $tracer;

    /**
     * ClientWithTracer constructor.
     * @param string|null $uri
     * @param null $options
     * @param Tracer|null $tracer
     * @throws \ReflectionException
     */
    public function __construct(string $uri = null, $options = null, Tracer $tracer = null)
    {
        parent::__construct($uri, $options);
        InsideConstruct::init(['tracer' => Tracer::class]);
    }

    public function send(Request $request = null)
    {
        $span = $this->tracer->start('send', [
            new StringTag('className', self::class),
            new StringTag('request.json', Serializer::jsonSerialize($request))
        ]);

        $context = $this->tracer->getContext();
        $tracerHeader = json_encode($context);
        $headers = $request->getHeaders();
        if ($headers instanceof Headers) {
            $headers->addHeaderLine(self::TRACER_HEADER_NAME, $tracerHeader);
        }
        $response = parent::send($request);

        $this->tracer->finish($span);
        return $response;
    }

    public function __wakeup()
    {
        InsideConstruct::initWakeup(['tracer' => Tracer::class]);
    }
}