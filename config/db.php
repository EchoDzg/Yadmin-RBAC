<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yadmin',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8',
    'tablePrefix' => 'y_',   //前缀
    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
