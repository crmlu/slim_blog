<?php

declare(strict_types=1);

namespace App\Models;

use Psr\Container\ContainerInterface;

class UsersModel extends BaseModel
{
    protected \PDO $db;
    protected string $table;

    public function __construct(ContainerInterface $container) 
    {
        parent::__construct($container);
        $this->table = 'users';
    }

    public function getByUsername(string $username): ?array
    {
        try {
            $st = $this->db->prepare("SELECT * FROM {$this->table} WHERE username = ?");
            $st->execute([$username]);
            $user = $st->fetch();
            if (!$user) {
                return null;
            }
            return $user;
        } catch (\PDOException $e) {
            return null;
        }
    }
    
    public function getByEmail(string $email): ?array
    {
        try {
            $st = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = ?");
            $st->execute([$email]);
            $user = $st->fetch();
            if (!$user) {
                return null;
            }
            return $user;
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function insert(array $data): bool
    {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        unset($data['password2']);
        return parent::insert($data);
    }

    public function update(array $data): bool
    {
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($password);
        }
        unset($data['password2']);
        unset($data['current_password']);
        return parent::update($data);
    }
}
