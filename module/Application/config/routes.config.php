<?php

declare(strict_types=1);

use Laminas\Router\Http\Segment;
use Laminas\Router\Http\Literal;
use Application\Controller\UserController;

return [
    'users' => [
        'type' => Literal::class,
        'options' => [
            'route' => '/api/list-users',
            'defaults' => [
                'controller' => UserController::class,
                'action'     => 'index',
            ],
        ],
    ],
    'create-user' => [
        'type' => Literal::class,
        'options' => [
            'route'    => '/api/create-user',
            'defaults' => [
                'controller' => UserController::class,
                'action'     => 'create',
            ],
        ],
    ],
    'get-user' => [
        'type' => Segment::class,
        'options' => [
            'route'    => '/api/get-user[/:id]',
            'defaults' => [
                'controller' => UserController::class,
                'action'     => 'get',
            ],
        ],
    ],
    'update-user' => [
        'type' => Segment::class,
        'options' => [
            'route'    => '/api/update-user[/:id]',
            'defaults' => [
                'controller' => UserController::class,
                'action'     => 'update',
            ],
        ],
    ],
    'delete-user' => [
        'type' => Segment::class,
        'options' => [
            'route'    => '/api/delete-user[/:id]',
            'defaults' => [
                'controller' => UserController::class,
                'action'     => 'delete',
            ],
        ],
    ],
];
