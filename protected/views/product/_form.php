<?php 
	$form = $this->beginWidget('CActiveForm', array(
		'id'=>'product-form',
		'enableClientValidation' => true,
	    'enableAjaxValidation' => true,
		'htmlOptions' => array(
			'enctype' => 'multipart/form-data',
			'autocomplete' => 'off',
			'class' => isset($ajaxRequest) ? 'ajax-submit' : '',
		)
	)); 

	$columnSize = '3';

	if(isset($ajaxRequest)) {
		$columnSize = '6';
	}
?>

<div class="row">

	<div class="col-md-<?php echo $columnSize; ?>">

		<div class="form-group">
			<?php echo $form->labelEx($model, 'name'); ?>
			<?php echo $form->textField($model, 'name', array('maxlength' => 100)); ?>
			<?php echo $form->error($model, 'name'); ?>
		</div>

	</div>
	
</div>

<div class="row buttons" style="margin-top: 30px;">

    <div class="col-md-<?php echo $columnSize; ?>">
        <?php echo CHtml::submitButton(Yii::t('base', $model->isNewRecord ? 'Create' : 'Save'), 
										array('class' => 'btn btn-proces-red btn-block')); ?>
    </div>

    <div class="col-md-<?php echo $columnSize; ?>">
        <?php echo CHtml::link(Yii::t('base', 'Cancel'), 
								$this->createAbsoluteUrl('area/admin'), 
								array('class'=> 'btn btn-proces-white btn-block cancel-button')); ?>
    </div>

</div>
<?php $this->endWidget(); ?>
