<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractRestfulController;
use Laminas\View\Model\JsonModel;
use Application\Model\UserTable;
use Laminas\Http\Response;
use Throwable;
use Application\Controller\Plugin\JsonErrorHandler;

class UserController extends AbstractRestfulController
{
    private UserTable $userTable;

    public function __construct(UserTable $userTable)
    {
        $this->userTable = $userTable;
    }

    public function createAction()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!isset($data['name'], $data['email'], $data['password'])) {
                return new JsonModel([
                    'error' => 'Parâmetros inválidos! Certifique-se de enviar name, email e password.'
                ]);
            }

            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
            $this->userTable->createUser($data);

            return new JsonModel(['message' => 'Usuário criado com sucesso!']);
        } catch (Throwable $e) {
            return $this->plugin(JsonErrorHandler::class)($e);
        }
    }

    public function getListAction()
    {
        try {
            $users = $this->userTable->fetchAll();
            return new JsonModel(['users' => $users]);
        } catch (Throwable $e) {
            return $this->plugin(JsonErrorHandler::class)($e);
        }
    }
}
