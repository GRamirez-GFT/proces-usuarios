<?php
return CMap::mergeArray(
    array(
        'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
        'name' => 'Proces | Administración de Proyectos',
        'charset' => 'UTF-8',
        'theme' => 'proyectos',
        'language' => 'es',
        'import' => array(
            'application.components.*',
            'application.models.*',
            'application.models.base.*'
        ),
        'modules' => array(),
        'components' => array(
            'user' => array(
                'authTimeout' => 3600
            ),
            'urlManager' => array(
                'urlFormat' => 'path',
                'showScriptName' => false,
                'rules' => array(
                    '<controller:\w+>/<id:\d+>' => '<controller>/view',
                    '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                    '<controller:\w+>/<action:\w+>/<id:\w+==>' => '<controller>/<action>'
                )
            ),
            'coreMessages' => array(
                'basePath' => dirname(__FILE__) . '/../messages'
            ),
            'errorHandler' => array(
                'errorAction' => 'site/error'
            )
        )
    ), require_once dirname(__FILE__) . '/params.php');
