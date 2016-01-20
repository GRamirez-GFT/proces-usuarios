<?php
switch ($_SERVER['SERVER_NAME']) {
    
    /* En caso que el nombre del servidor local sea diferente también se debe modificar en
    *  el archivo "protected/controllers/WsController.php" en la función validateRestrictedConnection()
    */
    case 'localhost':
    case '127.0.0.1':
        defined('YII_DEBUG') or define('YII_DEBUG', true);
        defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
        require_once dirname(__FILE__) . '/../yii/yii.php';
        $config = dirname(__FILE__) . '/protected/config/local.php';
    break;
    default:
        error_reporting(0);
        date_default_timezone_set('America/Mexico_City');
        require_once dirname(__FILE__) . '/../yii/yiilite.php';
        $config = dirname(__FILE__) . '/protected/config/main.php';
}
Yii::createWebApplication($config)->run();
