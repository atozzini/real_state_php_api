<?php

declare(strict_types=1);

use Application\Controller\UserController;
use Application\Controller\IndexController;
use Application\Controller\Plugin\JsonErrorHandler;
use Application\Model\UserTable;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\Adapter\AdapterServiceFactory;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => include __DIR__ . '/routes.config.php',
    ],
    'view_manager' => [
        'strategies' => ['ViewJsonStrategy'],
        'display_exceptions' => true,
        'not_found_template' => 'error/json',
        'exception_template' => 'error/json',
    ],
    'controllers' => [
        'factories' => [
            IndexController::class => InvokableFactory::class,
            UserController::class => function ($container) {
                return new UserController(
                    $container->get(UserTable::class)
                );
            },
        ],
    ],
    'service_manager' => [
        'factories' => [
            'Laminas\Db\Adapter\Adapter' => AdapterServiceFactory::class,
            UserTable::class => function ($container) {
                $dbAdapter = $container->get('Laminas\Db\Adapter\Adapter');
                return new UserTable(new TableGateway('users', $dbAdapter));
            },
        ],
        'controller_plugins' => [
            'factories' => [
                JsonErrorHandler::class => InvokableFactory::class,
            ],
        ],
    ],
];
