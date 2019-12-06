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
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];
