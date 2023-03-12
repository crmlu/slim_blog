<?php
declare(strict_types=1);

namespace App\Models;

use Psr\Container\ContainerInterface;

class ArticlesModel extends BaseModel
{
    protected \PDO $db;
    protected string $table;

    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
        $this->table = 'articles';
    }

    public function getByID(int $id): ?array
    {
        try{
            $st = $this->db->prepare(
                "SELECT
                    a.*, u.id AS file_id, u.name AS file_name
                FROM
                    {$this->table} AS a
                LEFT JOIN
                    uploads AS u ON u.id = a.image
                WHERE
                    a.id = ?"
            );
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

    public function list(): array
    {
        $st = $this->db->query(
            "SELECT
                a.*, u.id AS file_id, u.name AS file_name
            FROM
                {$this->table} AS a
            LEFT JOIN
                uploads AS u ON u.id = a.image"
        );
        return $st->fetchAll() ?? [];
    }
}
