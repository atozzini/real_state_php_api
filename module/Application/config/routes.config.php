<?php

declare(strict_types=1);

use Laminas\Router\Http\Segment;
use Laminas\Router\Http\Literal;
use Application\Controller\UserController;

return [
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
    'users' => [
        'type' => Segment::class,
        'options' => [
            'route' => '/api/users',
            'defaults' => [
                'controller' => UserController::class,
                'action'     => 'index',
            ],
        ],
    ],
];
