<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            // advanced_yii2 is the database name
            'dsn' => 'pgsql:host=localhost;dbname=desktop_tasks',
            'username' => 'postgres',
            'password' => 'arts123',
            'charset' => 'utf8',
        ]]];