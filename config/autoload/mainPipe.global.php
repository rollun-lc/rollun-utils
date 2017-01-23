<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 23.01.17
 * Time: 17:41
 */

use rollun\utils\MainPipe\Factory\MainPipeFactoryAbstract;
use rollun\utils\MainPipe\ResponseReturnerFactory;

return [
    'dependencies' => [
        'invokables' => [
        ],
        'factories' => [
        ],
    ],
    MainPipeFactoryAbstract::KEY_MAIN_PIPE => [
        /*'home' => [
            'middlewares' => [
            ]
        ]*/
    ],
    ResponseReturnerFactory::KEY_RESPONSE_RETURNER => [
        ResponseReturnerFactory::KEY_ACCEPT_TYPE_PATTERN => [
            //pattern => middleware
        ]
    ]

];