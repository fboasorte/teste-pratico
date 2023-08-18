<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=localhost;dbname=prova',
    'username' => 'aluno',
    'password' => '123456',
    'charset' => 'utf8',
    'schemaMap' => [
        'pgsql' => [
            'class' => \yii\db\pgsql\Schema::class,
            'columnSchemaClass' => [
                'class' => \yii\db\pgsql\ColumnSchema::class,
                'deserializeArrayColumnToArrayExpression' => false,
            ],
        ],
    ],
    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
