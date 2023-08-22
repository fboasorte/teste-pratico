<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

use     kartik\datecontrol\Module;

Yii::setAlias('arquivos', dirname(__DIR__) . '/arquivos');

Yii::$classMap['helpers\BancoHelper'] = '@app/helpers/BancoHelper.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'timeZone' => 'America/Bahia',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'KYdv-w57k5KmMKFd4fTWMp4vKGFu7yFq',
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
        'db' => $db,
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'defaultTimeZone' => 'America/Bahia',
            'currencyCode' => 'BRL',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
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
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
    $config['modules']['datecontrol'] = [
        'class' => 'kartik\datecontrol\Module',
                'displaySettings' => [
                    Module::FORMAT_DATE => 'dd/MM/yyyy',
                    Module::FORMAT_TIME => 'HH:mm',
                    Module::FORMAT_DATETIME => 'dd/MM/yyyy HH:mm',
                ],
                'saveSettings' => [
                    Module::FORMAT_DATE => 'php:Y-m-d',
                    Module::FORMAT_TIME => 'php:H:i:s',
                    Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
                ],
                // automatically use kartik\widgets for each of the above formats
                'autoWidget' => true,
                // converte data entre formatos de displaySettings e saveSettings via chamada ajax.
                'ajaxConversion' => true,
                'autoWidgetSettings' => [
                    Module::FORMAT_DATE => [
                        'type' => 2,
                        'pluginOptions' => ['autoclose' => true],
                        'options' => ['autocomplete' => 'off']
                    ],
                    Module::FORMAT_DATETIME => [
                        'pluginOptions' => ['autoclose' => true],
                        'options' => ['autocomplete' => 'off']
                    ],
                    Module::FORMAT_TIME => [],
                ],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
