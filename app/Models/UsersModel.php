<?php

declare(strict_types=1);

namespace App\Models;

use Psr\Container\ContainerInterface;

class UsersModel
{
    protected \PDO $db;
    protected string $table;

    public function __construct(ContainerInterface $container) 
    {
        $this->db = $container->get('db');
        $this->table = 'users';
    }

    public function list(): array
    {
        $st = $this->db->query("SELECT * FROM {$this->table}");
        return $st->fetchAll() ?? [];
    }

    public function getByUsername(string $username): ?array
    {
        $st = $this->db->prepare("SELECT * FROM {$this->table} WHERE username = ?");
        $st->execute([$username]);
        $user = $st->fetch();
        return $user;
    }
    
    public function getByID(int $id): ?array
    {
        $st = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $st->execute([$id]);
        $user = $st->fetch();
        return $user;
    }
}
