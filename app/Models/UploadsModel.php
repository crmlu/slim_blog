<?php
declare(strict_types=1);

namespace App\Models;

use Psr\Container\ContainerInterface;

class UploadsModel
{
    protected \PDO $db;
    protected string $table;

    public function __construct(ContainerInterface $container) {
        $this->db = $container->get('db');
        $this->table = 'uploads';
    }

    public function insert(array $data): ?int
    {
        try {
            $columns = array();
            $q = "INSERT INTO {$this->table} SET ";     
            foreach ($data as $key => $item) {
                $columns[] = "{$key} = :{$key}";
            }
            $st = $this->db->prepare($q . implode(',' , $columns));
            $st->execute($data);
            return (int)$this->db->lastInsertId();
        } catch(\PDOException $e) {
            return null;
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
            $item = $st->fetch();
            if (!$item) {
                return null;
            }
            return $item;
        } catch (\PDOException $e) {
            return null;
        }
    }
}
