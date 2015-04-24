<?php

return [
    'Migrations' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'development',
        'environments' => [
            'development' => [
                'adapter' => 'pgsql',
                'host' => 'localhost',
                'name' => 'radphp_db',
                'user' => 'radphp_user',
                'pass' => 'rad123',
                'port' => 5432,
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci'
            ]
        ]
    ]
];
