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
}
