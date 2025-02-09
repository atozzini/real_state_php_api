<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractRestfulController;
use Laminas\View\Model\JsonModel;
use Application\Model\UserTable;
use Laminas\Http\Response;
use Throwable;

class UserController extends AbstractRestfulController
{
    private UserTable $userTable;

    public function __construct(UserTable $userTable) {
        $this->userTable = $userTable;
    }

    public function indexAction() {
        try {
            $users = $this->userTable->fetchAll();
            return new JsonModel(['users' => $users]);
        } catch (Throwable $e) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_500);
            return new JsonModel([
                'error' => 'Erro interno no servidor',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function getAction() {
        try {
            $id = (int) $this->params()->fromRoute('id', 0);
            if (!$id) {
                return new JsonModel(['error' => 'ID do usuário não informado.'], Response::STATUS_CODE_400);
            }

            $user = $this->userTable->findUserById($id);
            if (!$user) {
                return new JsonModel(['error' => 'Usuário não encontrado.'], Response::STATUS_CODE_404);
            }

            return new JsonModel($user);
        } catch (Throwable $e) {
            return new JsonModel(['error' => 'Erro interno no servidor', 'message' => $e->getMessage()], Response::STATUS_CODE_500);
        }
    }

    public function createAction() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!isset($data['name'], $data['email'], $data['password'])) {
                $this->getResponse()->setStatusCode(Response::STATUS_CODE_400);
                return new JsonModel([
                    'error' => 'Parâmetros inválidos! Certifique-se de enviar name, email e password.'
                ]);
            }

            $existingUser = $this->userTable->findUserByEmail($data['email']);
            if ($existingUser) {
                $this->getResponse()->setStatusCode(Response::STATUS_CODE_409);
                return new JsonModel([
                    'error' => 'Este e-mail já está cadastrado.'
                ]);
            }

            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
            $this->userTable->createUser($data);

            $this->getResponse()->setStatusCode(Response::STATUS_CODE_201);
            return new JsonModel(['message' => 'Usuário criado com sucesso!']);
        } catch (Throwable $e) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_500);
            return new JsonModel(['error' => $e->getMessage()]);
        }
    }

    public function updateAction() {
        try {
            $id = (int) $this->params()->fromRoute('id', 0);
            $data = json_decode(file_get_contents('php://input'), true);

            if (!$id) {
                return new JsonModel(['error' => 'ID do usuário não informado.'], Response::STATUS_CODE_400);
            }

            if (!$this->userTable->findUserById($id)) {
                return new JsonModel(['error' => 'Usuário não encontrado.'], Response::STATUS_CODE_404);
            }

            if (isset($data['password'])) {
                $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
            }

            $this->userTable->updateUser($id, $data);
            return new JsonModel(['message' => 'Usuário atualizado com sucesso!']);
        } catch (Throwable $e) {
            return new JsonModel(['error' => $e->getMessage()], Response::STATUS_CODE_500);
        }
    }

    public function deleteAction() {
        try {
            $id = (int) $this->params()->fromRoute('id', 0);

            if (!$id) {
                return new JsonModel(['error' => 'ID do usuário não informado.'], Response::STATUS_CODE_400);
            }

            if (!$this->userTable->findUserById($id)) {
                return new JsonModel(['error' => 'Usuário não encontrado.'], Response::STATUS_CODE_404);
            }

            $this->userTable->deleteUser($id);
            return new JsonModel(['message' => 'Usuário deletado com sucesso!']);
        } catch (Throwable $e) {
            return new JsonModel(['error' => $e->getMessage()], Response::STATUS_CODE_500);
        }
    }
}
