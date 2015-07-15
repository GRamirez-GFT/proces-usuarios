<?php
return CMap::mergeArray(require_once dirname(__FILE__) . '/common.php',
    array(
        'components' => array(
            'db' => array(
                'class' => 'CDbConnection',
                'connectionString' => 'mysql:host=localhost;dbname=pro_users',
                'username' => 'proces',
                'password' => 'Pr0ce55$%',
                'charset' => 'utf8'
            ),
            'cache' => array(
                'class' => 'CFileCache'
            )
        )
    ));
