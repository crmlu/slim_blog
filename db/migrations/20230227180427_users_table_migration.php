<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UsersTableMigration extends AbstractMigration
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
        $users = $this->table('users');
        $users
            ->addColumn('name', 'string', ['limit' => 100, 'null' => false])
            ->addColumn('username', 'string', ['limit' => 100, 'null' => false])
            ->addColumn('email', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('password', 'string', ['limit' => 255, 'null' => false])
            ->addIndex(['username'], ['unique' => true])
            ->addIndex(['email'], ['unique' => true])
            ->create();
        
        $user_data = [
            'name'  => 'Test User',
            'username' => 'admin',
            'email' => 'admin@testslimblog.blog',
            'password' => password_hash('admin', PASSWORD_DEFAULT),
        ];

        $users->insert($user_data)->saveData();
    
    }
}
