<?php

declare(strict_types=1);

return [
    'router' => [
        'routes' => [
            'create-user' => [
                'type' => \Laminas\Router\Http\Literal::class,
                'options' => [
                    'route'    => '/api/create-user',
                    'defaults' => [
                        'controller' => Application\Controller\UserController::class,
                        'action'     => 'create',
                    ],
                ],
            ],
            'users' => [
                'type' => \Laminas\Router\Http\Segment::class,
                'options' => [
                    'route' => '/api/users',
                    'defaults' => [
                        'controller' => Application\Controller\UserController::class,
                        'action'     => 'getList',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'strategies' => ['ViewJsonStrategy'],
        'display_exceptions' => true, // Mostra erros detalhados
        'not_found_template' => 'error/json', // Garante que erros 404 retornem JSON
        'exception_template' => 'error/json', // Garante que exceções retornem JSON
    ],
    'controllers' => [
        'factories' => [
            Application\Controller\IndexController::class => \Laminas\ServiceManager\Factory\InvokableFactory::class,
            Application\Controller\UserController::class => function ($container) {
                return new Application\Controller\UserController(
                    $container->get(Application\Model\UserTable::class)
                );
            },
        ],
    ],
    'service_manager' => [
        'factories' => [
            'Laminas\Db\Adapter\Adapter' => Laminas\Db\Adapter\AdapterServiceFactory::class,
            Application\Model\UserTable::class => function ($container) {
                $dbAdapter = $container->get('Laminas\Db\Adapter\Adapter');
                return new Application\Model\UserTable(new Laminas\Db\TableGateway\TableGateway('users', $dbAdapter));
            },
        ],
        'controller_plugins' => [
            'factories' => [
                Application\Controller\Plugin\JsonErrorHandler::class => InvokableFactory::class,
            ],
        ],
    ],
];
