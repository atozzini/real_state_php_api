<?php

declare(strict_types=1);

namespace Application\Model;

use Laminas\Db\TableGateway\TableGatewayInterface;

class UserTable
{
    private TableGatewayInterface $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function createUser(array $data): void
    {
        $this->tableGateway->insert([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function fetchAll(): array
    {
        return $this->tableGateway->select()->toArray();
    }
}
