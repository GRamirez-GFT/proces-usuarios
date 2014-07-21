<?php
return CMap::mergeArray(require_once dirname(__FILE__) . '/common.php',
    array(
        'modules' => array(
            'gii' => array(
                'class' => 'system.gii.GiiModule',
                'password' => 'root'
            )
        ),
        'components' => array(
            'db' => array(
                'class' => 'CDbConnection',
                'connectionString' => 'mysql:host=localhost:3308;dbname=pro_user',
                'username' => 'root',
                'password' => 'root',
                'charset' => 'utf8'
            ),
        )
    ));
