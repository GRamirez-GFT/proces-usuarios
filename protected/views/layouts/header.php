<head>

<meta http-equiv="Content-Type"
	content="text/html; charset=<?php echo Yii::app()->charset;?>">
<meta name="description" content="">
<meta name="author" content="">
<title><?php echo Yii::app()->controller->pageTitle;?></title>


<?php // TODO: AGREGAR ICONO DE LA PAGINA ?>
<link rel="shortcut icon" href="">

<?php
// TODO: REVISAR ESTILOS QUE NO SE USAN
Yii::app()->clientScript
    ->registerCssFile('http://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic,700italic')
    /*
    ->registerCssFile($this->assets . '/css/screen.css')
    ->registerCssFile($this->assets . '/css//jui/table.css')
    ->registerCssFile($this->assets . '/css//jui/fullcalendar.css')
    ->registerCssFile($this->assets . '/css/elfinder.css')
    ->registerCssFile($this->assets . '/css/tipsy.css')
    ->registerCssFile($this->assets . '/css/chosen.css')
    ->registerCssFile($this->assets . '/css/jquery.jgrowl.css')
    */
    ->registerCssFile($this->assets . '/css/style.css')
    ->registerCoreScript('jquery')
    ->registerCoreScript('jquery.ui');
?>
</head>