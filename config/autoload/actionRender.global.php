<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 23.01.17
 * Time: 17:41
 */

use rollun\utils\ActionRender\Factory\AbstractMiddlewarePipeFactoryAbstract;
use rollun\utils\ActionRender\Factory\ActionRenderFactory;
use rollun\utils\ActionRender\Renderer\ResponseRendererFactory;

return [
    'dependencies' => [
        'abstract_factories' => [
            AbstractMiddlewarePipeFactoryAbstract::class,
            ActionRenderFactory::class,
            ResponseRendererFactory::class
        ],
        'invokables' => [
            \rollun\utils\ActionRender\Renderer\Html\HtmlParamResolver::class =>
                \rollun\utils\ActionRender\Renderer\Html\HtmlParamResolver::class
        ],
        'factories' => [
            \rollun\utils\ActionRender\Renderer\Html\HtmlRendererAction::class =>
                \rollun\utils\ActionRender\Renderer\Html\HtmlRendererFactory::class
        ],
    ],
    AbstractMiddlewarePipeFactoryAbstract::KEY_AMP => [
        'htmlReturner' => [
            'middlewares' => [
                \rollun\utils\ActionRender\Renderer\Html\HtmlParamResolver::class,
                \rollun\utils\ActionRender\Renderer\Html\HtmlRendererAction::class
            ]
        ]
    ],
    ResponseRendererFactory::KEY_RESPONSE_RENDERER => [
        'simpleHtmlJsonRenderer' => [
            ResponseRendererFactory::KEY_ACCEPT_TYPE_PATTERN => [
                //pattern => middleware-Service-Name
                '/application\/json/' => \rollun\utils\ActionRender\Renderer\Json\JsonRendererAction::class,
                '/text\/html/' => 'htmlReturner'
            ]
        ]
    ],
    ActionRenderFactory::KEY_ACTION_RENDER => [
        /*'home' => [
            // ActionRenderFactory::KEY_AR_MIDDLEWARE => 'ActionRenderMiddleware'
            ActionRenderFactory::KEY_AR_MIDDLEWARE => [
                ActionRenderFactory::KEY_ACTION => '',
                ActionRenderFactory::KEY_RENDER => 'simpleHtmlJsonRenderer'
            ]
        ],*/
    ]
];