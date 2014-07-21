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
//    ->registerCssFile($this->assets . '/css/screen.css')
    ->registerCssFile($this->assets . '/css/table.css')
    ->registerCssFile($this->assets . '/css/jui/jquery.ui.css')
//    ->registerCssFile($this->assets . '/css//jui/fullcalendar.css')
//    ->registerCssFile($this->assets . '/css/elfinder.css')
    ->registerCssFile($this->assets . '/css/tipsy.css')
//    ->registerCssFile($this->assets . '/css/chosen.css')
//    ->registerCssFile($this->assets . '/css/jquery.jgrowl.css')
    ->registerCssFile($this->assets . '/css/style.css')
    ->registerScriptFile($this->assets . '/js/jquery-1.7.1.min.js', CClientScript::POS_END)
    ->registerScriptFile($this->assets . '/js/jquery-ui-1.10.4.custom.min.js', CClientScript::POS_END)
    ->registerScriptFile($this->assets . '/js/jquery.dataTables.js', CClientScript::POS_END)
    ->registerScriptFile($this->assets . '/js/jquery.tipsy-min.js', CClientScript::POS_END)
    ->registerScriptFile($this->assets . '/js/functions.js', CClientScript::POS_END);
?>
</head>

<!--
<script type="text/javascript" src="<?php echo $this->assets; ?>/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo $this->assets; ?>/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?php echo $this->assets; ?>/js/jquery.numeric.js"></script>
<script type="text/javascript" src="<?php echo $this->assets; ?>/js/fullcalendar.min.js"></script>
<script type="text/javascript" src="<?php echo $this->assets; ?>/js/elfinder.min.js"></script>
<script type="text/javascript" src="<?php echo $this->assets; ?>/js/i18n/elfinder.es.js"></script>
<script type="text/javascript" src="<?php echo $this->assets; ?>/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $this->assets; ?>/js/jquery.tipsy-min.js"></script>
<script type="text/javascript" src="<?php echo $this->assets; ?>/js/excanvas.min.js"></script>
<script type="text/javascript" src="<?php echo $this->assets; ?>/js/jquery.flot.min.js"></script>
<script type="text/javascript" src="<?php echo $this->assets; ?>/js/jquery.flot.pie.min.js"></script>
<script type="text/javascript" src="<?php echo $this->assets; ?>/js/jquery.flot.stack.min.js"></script>
<script type="text/javascript" src="<?php echo $this->assets; ?>/js/jquery.flot.resize.min.js"></script>
<script type="text/javascript" src="<?php echo $this->assets; ?>/js/jquery.jgrowl-min.js"></script>


<script type="text/javascript" src="<?php echo $this->assets; ?>/js/functions.js"></script>
-->