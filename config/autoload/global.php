<?php

return [
    'db' => [
        'driver'   => 'Pdo',
        'dsn'      => 'pgsql:host=localhost;port=5433;dbname=real_state_php_api',
        'username' => 'postgres',
        'password' => 'qwerty',
    ],
    'service_manager' => [
        'factories' => [
            'Laminas\Db\Adapter\Adapter' => Laminas\Db\Adapter\AdapterServiceFactory::class,
        ],
    ],
];
