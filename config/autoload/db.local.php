<?php

use rollun\tableGateway\Factory\TableGatewayAbstractFactory;

return
    [
        'dependencies' => [
            'aliases' => [
                'db' => 'Zend\Db\Adapter\AdapterInterface',
            ],
        ],
        'db' => [
            'adapters' => [
                'TestDbAdapter' => [
                    'driver' => getenv('DB_DRIVER') ?: 'Pdo_Mysql',
                    'database' => getenv('DB_NAME'),
                    'username' => getenv('DB_USER'),
                    'password' => getenv('DB_PASS'),
                    'hostname' => getenv('DB_HOST'),
                    'port' => getenv('DB_PORT') ?: 3306,
                ],
            ],
            'driver' => getenv('DB_DRIVER') ?: 'Pdo_Mysql',
            'database' => getenv('DB_NAME'),
            'username' => getenv('DB_USER'),
            'password' => getenv('DB_PASS'),
            'hostname' => getenv('DB_HOST'),
            'port' => getenv('DB_PORT') ?: 3306,
        ],

        TableGatewayAbstractFactory::KEY => [
            "tbl_name_which_exist" => [],
            "tbl_iterable" => []
        ]
    ];