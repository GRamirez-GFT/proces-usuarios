<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'role-form',
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
		<?php echo $form->textField($model, 'name', array('maxlength' => 50)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'company_id'); ?>
		<?php echo $form->dropDownList($model, 'company_id', array('prompt' => Yii::t('base', 'select option'))); ?>
		<?php echo $form->error($model,'company_id'); ?>
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