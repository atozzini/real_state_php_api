<?php

declare(strict_types=1);

namespace Application\Controller\Plugin;

use Laminas\Mvc\Controller\Plugin\AbstractPlugin;
use Laminas\View\Model\JsonModel;
use Laminas\Http\Response;

class JsonErrorHandler extends AbstractPlugin
{
    public function __invoke($exception)
    {
        $response = new Response();
        $response->setStatusCode(Response::STATUS_CODE_500);

        return new JsonModel([
            'error'   => 'Erro interno no servidor',
            'message' => $exception->getMessage(),
        ]);
    }
}
