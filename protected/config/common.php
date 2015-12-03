<?php
return CMap::mergeArray(
    array(
        'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
        'name' => 'Proces | Administración de Usuarios',
        'charset' => 'UTF-8',
        'theme' => 'proces-bootstrap',
        'language' => 'es',
        'import' => array(
            'application.components.*',
            'application.models.*',
            'application.models.base.*',
        ),
        'aliases' => array(
            'RestfullYii' => realpath(__DIR__ . '/../extensions/RestfullYii'),
            'globalAccessControl' => realpath(__DIR__ . '/../filters/GlobalAccessControl'),
        ),
        'modules' => array(),
        'components' => array(
            'widgetFactory' => array(
                'widgets' => require_once dirname(__FILE__) . '/widgets.php'
            ),
            'user' => array(
                'authTimeout' => 3600000
            ),
            'urlManager' => array(
                'urlFormat' => 'path',
                'showScriptName' => false,
                'rules' => CMap::mergeArray(array(
                    '<controller:\w+>/<id:\d+>' => '<controller>/view',
                    '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                    '<controller:\w+>/<action:\w+>/<id:\w+==>' => '<controller>/<action>'
                ), require_once dirname(__FILE__).'/../extensions/RestfullYii/config/routes.php'),
            ),
            'coreMessages' => array(
                'basePath' => dirname(__FILE__) . '/../messages'
            ),
            'errorHandler' => array(
                'errorAction' => 'site/error'
            ),
            'log' => array(
                'class' => 'CLogRouter',
                'routes' => array(
                    array(
                        'class' => 'CFileLogRoute',
                        'levels' => 'error, warning'
                    ),
                     array(
                        'class'=>'CWebLogRoute',
                        'levels' => 'trace, info, error, warning'
                     ),
                )
            )
        )
    ), require_once dirname(__FILE__) . '/params.php');
