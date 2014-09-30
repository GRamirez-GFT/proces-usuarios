<?php
    $this->breadcrumbs = array(
        Yii::t('base','Products') => array('admin'),
        $model->name,
    );

	$columnSize = '5';

	if(isset($ajaxRequest)) {
		$columnSize = '12';
	}
?>

<?php if(isset($ajaxRequest)): ?>
	<div class="panel-options">
<?php endif; ?>


<<?php echo isset($ajaxRequest) ? 'h2' : 'h1';?>>
	<?php echo Yii::t('base', 'Product details') ?>
</<?php echo isset($ajaxRequest) ? 'h2' : 'h1';?>>

<?php if(isset($ajaxRequest)): ?>
	</div> <!-- end panel-options -->

	<div class="panel-content">
<?php endif; ?>

<div class="row">

	<div class="col-md-12 <?php echo isset($ajaxRequest) ? 'panel-actions' : ''; ?>">

<?php
	$ajaxUpdate = isset($ajaxRequest) ? 'panel-trigger' : '';

	echo CHtml::link('', Yii::app()->createAbsoluteUrl('product/update/?id='.$model->id), 
		array(
		'class' => 'btn btn-proces-white phantom-btn fa fa-pencil mws-tooltip-s '.$ajaxUpdate,
		'original-title' => Yii::t('base','Update')
	));
	
	$ajaxDelete = isset($ajaxRequest) ? 'ajax-delete' : '';
	
	echo CHtml::link('', Yii::app()->createAbsoluteUrl('product/delete/?id='.$model->id), 
		array(
		'class' => 'btn btn-proces-white phantom-btn fa fa-trash mws-tooltip-s confirm-action '.$ajaxDelete,
		'original-title' => Yii::t('base','Delete')
	));
?>
	</div>

	<div class="col-md-<?php echo $columnSize; ?>">
		
		<p>
			<span class="labeling"><?php echo  Yii::t('models/Product', 'name'); ?>:</span>
			<?php echo $model->name; ?>
		</p>

		<p>
			<span class="labeling"><?php echo  Yii::t('models/Product', 'token'); ?>:</span>
			<?php echo $model->token; ?>
		</p>

	</div>

</div>