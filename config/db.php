<?php

return [
   /*
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    */
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=db_pronuntia',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    'on afterOpen' => function($event) {

        // $event->sender refers to the DB connection
        $event->sender->createCommand("SET lc_time_names = 'it_IT';")->execute();

    }
    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
