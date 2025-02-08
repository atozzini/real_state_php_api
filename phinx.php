<?php

return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'development',

        'development' => [
            'adapter' => 'pgsql',
            'host' => '127.0.0.1',
            'name' => 'real_state_php_api',
            'user' => 'postgres',
            'pass' => 'qwerty',
            'port' => '5433',
            'charset' => 'utf8',
        ],
    ],
    'version_order' => 'creation'
];
