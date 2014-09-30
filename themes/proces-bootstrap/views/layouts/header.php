<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo Yii::app()->charset;?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta name="description" content="">
<meta name="author" content="">
<title><?php echo Yii::app()->controller->pageTitle;?></title>
<?php
Yii::app()->clientScript->registerLinkTag('shortcut icon', null, $this->assets . '/img/favicon.ico')
    ->registerCssFile($this->assets . '/css/jquery-ui.min.css')
    ->registerCssFile($this->assets . '/css/visualsearch.css')
    ->registerCssFile($this->assets . '/css/bootstrap.min.css')
    ->registerCssFile($this->assets . '/css/font-awesome.min.css')
    ->registerCssFile($this->assets . '/css/select2' . (YII_DEBUG ? null : '.min') . '.css')
    ->registerCssFile($this->assets . '/css/tipsy' . (YII_DEBUG ? null : '.min') . '.css')
    ->registerCssFile($this->assets . '/css/style' . (1 ? null : '.min') . '.css')
    ->registerCoreScript('jquery')
    ->registerScriptFile($this->assets . '/js/bootstrap.min.js', CClientScript::POS_END)
    ->registerScriptFile($this->assets . '/js/select2.min.js', CClientScript::POS_END)
    ->registerScriptFile($this->assets . '/js/jquery.tipsy.min.js', CClientScript::POS_END)
    ->registerScriptFile($this->assets . '/js/functions' . (YII_DEBUG ? null : '.min') . '.js', CClientScript::POS_END);
?>
</head>