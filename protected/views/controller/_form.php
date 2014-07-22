<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'controller-form',
	'enableClientValidation' => true,  
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data',
		'autocomplete' => 'off',
	)
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model, 'name'); ?>
		<?php echo $form->textField($model, 'name', array('maxlength' => 100)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'url_controller'); ?>
		<?php echo $form->textArea($model, 'url_controller', array('style' => 'resize: none;')); ?>
		<?php echo $form->error($model,'url_controller'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'product_id'); ?>
		<?php echo $form->dropDownList($model, 'product_id', array('prompt' => Yii::t('base', 'select option'))); ?>
		<?php echo $form->error($model,'product_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div>