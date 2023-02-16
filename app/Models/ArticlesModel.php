<?php
declare(strict_types=1);

namespace App\Models;

use Psr\Container\ContainerInterface;

class ArticlesModel
{
    protected \PDO $db;
    protected string $table;

    public function __construct(ContainerInterface $container) {
        $this->db = $container->get('db');
        $this->table = 'articles';
    }

    public function list(): array
    {
        $st = $this->db->query("SELECT * FROM {$this->table}");
        return $st->fetchAll() ?? [];
    }

    public function insert(array $data): bool
    {
        try {
            $st = $this->db->prepare("
                INSERT INTO {$this->table}
                SET
                    title = :title,
                    content = :content"
            );
            $st->execute($data);
            return true;
        }
        catch(\PDOException $e) {
            return false;
        }
    }

    public function update(array $data): bool
    {
        try {
            $st = $this->db->prepare("
                UPDATE {$this->table}
                SET
                    title = :title,
                    content = :content
                WHERE id = :id"
            );
            $st->execute($data);
            return true;
        }
        catch(\PDOException $e) {
            return false;
        }
    }

    public function getByID(int $id): ?array
    {
        $st = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $st->execute([$id]);
        $user = $st->fetch();
        return $user;
    }

    public function delete(int $id): bool
    {
        try {
            $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?")->execute([$id]);
            return true;
        }
        catch(\PDOException $e) {
            return false;
        }
    }
}
