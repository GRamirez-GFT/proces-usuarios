<?php
return CMap::mergeArray(require_once dirname(__FILE__) . '/common.php',
    array(
        'components' => array(
            'db' => array(
                'class' => 'CDbConnection',
                'connectionString' => 'mysql:host=localhost;dbname=pro_user',
                'username' => 'root',
                'password' => 'root',
                'charset' => 'utf8'
            ),
            'cache' => array(
                'class' => 'CFileCache'
            )
        )
    ));
