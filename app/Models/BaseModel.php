<?php
declare(strict_types=1);

namespace App\Models;

use Psr\Container\ContainerInterface;

class BaseModel
{
    protected \PDO $db;
    protected string $table;

    public function __construct(ContainerInterface $container) {
        $this->db = $container->get('db');
    }

    public function list(): array
    {
        $st = $this->db->query("SELECT * FROM {$this->table}");
        return $st->fetchAll() ?? [];
    }

    public function insert(array $data): bool
    {
        try {
            $columns = array();
            $q = "INSERT INTO {$this->table} SET ";     
            foreach ($data as $key => $item) {
                $columns[] = "{$key} = :{$key}";
            }
            $st = $this->db->prepare($q . implode(',' , $columns));
            $st->execute($data);
            return true;
        } catch(\PDOException $e) {
            return false;
        }
    }

    public function update(array $data): bool
    {
        try {
            $columns = array();
            $q = "UPDATE {$this->table} SET ";     
            foreach ($data as $key => $item) {
                $columns[] = "{$key} = :{$key}";
            }
            $q = $q . implode(',' , $columns). ' WHERE id = :id';
            $st = $this->db->prepare($q);
            $st->execute($data);
            return true;
        } catch(\PDOException $e) {
            return false;
        }
    }

    public function delete(int $id): bool
    {
        try {
            $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?")->execute([$id]);
            return true;
        } catch(\PDOException $e) {
            return false;
        }
    }

    public function getByID(int $id): ?array
    {
        try{
            $st = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
            $st->execute([$id]);
            $user = $st->fetch();
            if (!$user) {
                return null;
            }
            return $user;
        } catch (\PDOException $e) {
            return null;
        }
    }
}
