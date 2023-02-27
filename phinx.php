<?php

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'development' => [
            'adapter' => 'mysql',
            'host' => 'localhost',
            'name' => 'database',
            'user' => 'user',
            'pass' => 'password',
            'port' => '3306',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_general_ci'
        ],
    ],
    'version_order' => 'creation'
];
