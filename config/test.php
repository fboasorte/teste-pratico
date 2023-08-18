<?php
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/test_db.php';

use kartik\datecontrol\Module;

/**
 * Application configuration shared by all test types
 */
return [
    'id' => 'basic-tests',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language' => 'pt-BR',
    'components' => [
        'db' => $db,
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
            'messageClass' => 'yii\symfonymailer\Message'
        ],
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
        'user' => [
            'identityClass' => 'app\models\User',
        ],
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
            // but if you absolutely need it set cookie domain to localhost
            /*
            'csrfCookie' => [
                'domain' => 'localhost',
            ],
            */
        ],
        'modules' => [
            'datecontrol' => [
                'class' => '\kartik\datecontrol\Module',
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
            ],
        ],
        
    ],
    'params' => $params,
];
