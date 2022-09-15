<?php

declare(strict_types=1);

$params = require __DIR__ . '/params.php';
// $db = require __DIR__ . '/db.php';
$mongodb = require __DIR__ . '/mongodb.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'bQSKcLhTY7Rxw9C6QSF1y_T4KzcWHjU0',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'mongodb' => $mongodb,
        // 'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'PUT,PATCH authors/<id>' => 'author/update',
                'DELETE authors/<id>' => 'author/delete',
                'GET,HEAD authors/<id>' => 'author/view',
                'POST authors' => 'author/create',
                'GET,HEAD authors' => 'author/index',
                // 'authors/<id>' => 'author/options',
                // 'authors' => 'author/options',
                'PUT,PATCH books/<id>' => 'book/update',
                'DELETE books/<id>' => 'book/delete',
                'GET,HEAD books/<id>' => 'book/view',
                'POST books' => 'book/create',
                'GET,HEAD books' => 'book/index',
                // 'books/<id>' => 'book/options',
                // 'books' => 'book/options',
                // ['class' => 'yii\rest\UrlRule', 'controller' => 'author'],
                // ['class' => 'yii\rest\UrlRule', 'controller' => 'book'],
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        // 'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        // 'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
