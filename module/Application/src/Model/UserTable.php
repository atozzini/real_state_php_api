<?php

declare(strict_types=1);

namespace Application\Model;

use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Db\Sql\Select;

class UserTable {
    private TableGatewayInterface $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function createUser(array $data): void {
        $this->tableGateway->insert([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function fetchAll(): array {
        return $this->tableGateway->select()->toArray();
    }

    public function findUserByEmail(string $email) {
        $rowset = $this->tableGateway->select(['email' => $email]);
        return $rowset->current();
    }

    public function findUserById(int $id) {
        $rowset = $this->tableGateway->select(['id' => $id]);
        return $rowset->current();
    }

    public function updateUser(int $id, array $data): void {
        $data['updated_at'] = date('Y-m-d H:i:s');

        if (isset($data['email'])) {
            $existingUser = $this->tableGateway->select(['email' => $data['email']])->current();
            if ($existingUser && $existingUser->id !== $id) {
                echo "Erro: Este e-mail já está sendo usado por outro usuário." . PHP_EOL;
                throw new \Exception("Este e-mail já está sendo usado por outro usuário.");
            }
        }

        try {
            $this->tableGateway->update($data, ['id' => $id]);
        } catch (\Exception $e) {
            echo "Erro ao atualizar usuário: " . $e->getMessage() . PHP_EOL;
            error_log("Erro ao atualizar usuário: " . $e->getMessage()); // Salvar no log
            throw $e;
        }
    }


    public function deleteUser(int $id): void {
        $this->tableGateway->delete(['id' => $id]);
    }
}
