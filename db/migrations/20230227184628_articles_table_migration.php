<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ArticlesTableMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $articles = $this->table('articles');
        $articles
            ->addColumn('title', 'string', ['limit' => 1000, 'null' => false])
            ->addColumn('content', 'text')
            ->create();
    }
}
