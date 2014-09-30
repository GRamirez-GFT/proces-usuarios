<?php
$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>


<div class="pull-left">
	<img src="<?php echo $this->assets; ?>/img/error_page.png">
</div>

<div class="error-container pull-left">

	<h1>Error <?php echo $code; ?></h1>

	<p><?php echo CHtml::encode($message); ?></p>

</div>
