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
                    'driver' => 'Pdo_Mysql',
                    'database' => 'central_db',
                    'username' => 'root',
                    'password' => '123qwe321',
                ],
            ],
            'driver' => 'Pdo_Mysql',
            'database' => 'central_db',
            'username' => 'root',
            'password' => '123qwe321',
        ],

        TableGatewayAbstractFactory::KEY => [
            "tbl_name_which_exist" => [],
            "tbl_iterable" => []
        ]
    ];