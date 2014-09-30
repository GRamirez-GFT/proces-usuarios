<?php
	$this->breadcrumbs = array(
		Yii::t('base', 'Products') => array('admin'),
		$model->name => array('view','id' => $model->id),
		Yii::t('base', 'Update'),
	);

	if(isset($ajaxRequest)) {
		$cs = Yii::app()->clientScript;
		$cs->scriptMap['jquery.js'] = false;
	}
?>

<?php if(isset($ajaxRequest)): ?>
	<div class="panel-options">
<?php endif; ?>

<<?php echo isset($ajaxRequest) ? 'h2' : 'h1';?>>
	<?php echo Yii::t('base', 'Update').' '.Yii::t('models/Product', 'id'); ?>
</<?php echo isset($ajaxRequest) ? 'h2' : 'h1';?>>

<?php if(isset($ajaxRequest)): ?>
	</div> <!-- end panel-options -->

	<div class="panel-content">
<?php endif; ?>

<?php $this->renderPartial('_form', array('model'=>$model, 'ajaxRequest' => $ajaxRequest)); ?>

<?php if(isset($ajaxRequest)): ?>
	</div> <!-- end panel-content -->
<?php endif; ?>