<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            // advanced_yii2 is the database name
            'dsn' => env('DB_DSN'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'charset' => 'utf8',
        ],
    ],
];