<?php
$params = require(__DIR__ . '/../config/params.php');

require VENDOR_PATH . '/autoload.php';
require VENDOR_PATH . '/yiisoft/yii2/Yii.php';

$hash = hash('sha256', $_SERVER['HTTP_HOST']);

$config = [
    'id' => 'cv',
    'name' => APP_NAME,
    'basePath' => BASE_PATH,
    'language' => 'en-US',
    'controllerNamespace' => 'app\controllers',
    'bootstrap' => [
        'log',
    ],
    'vendorPath' => VENDOR_PATH,
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
        ],
        'db' => $params['db'],
        'cache' => [
            'class' => 'yii\caching\FileCache',
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
        'request' => [
            'csrfParam' => '_csrf-blog-' . $hash,
            'cookieValidationKey' => $params['cookieValidationKey'],
            'baseUrl' => $params['baseUrl'],
        ],
        'session' => [
            'name' => 'cv-blog-' . $hash,
            'cookieParams' => [
                'httpOnly' => true,
            ],
        ],
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-app', 'httpOnly' => true],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'normalizer' => [
                'class' => 'yii\web\UrlNormalizer',
                'collapseSlashes' => true,
                'normalizeTrailingSlash' => true,
            ],
            'rules' => [
                '<controller>/<action>/<id:\d+>' => '<controller>/<action>',
                '<controller>/<action>' => '<controller>/<action>',
                '<controller>/' => '<controller>/index',
                '' => 'site/index',
            ],
        ],
    ],
    'params' => $params['params'],
];

if (YII_ENV == 'dev') {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

(new yii\web\Application($config))->run();
