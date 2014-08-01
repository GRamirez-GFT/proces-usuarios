<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'product-form',
	'enableClientValidation' => true,
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data',
		'autocomplete' => 'off',
	)
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
		<?php echo $form->labelEx($model, 'name'); ?>
		<?php echo $form->textField($model, 'name', array('maxlength' => 100)); ?>
		<?php echo $form->error($model, 'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'url_product'); ?>
		<?php echo $form->textField($model, 'url_product', array('maxlength' => 255)); ?>
		<?php echo $form->error($model, 'url_product'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::button($model->isNewRecord ? 'Create' : 'Save', array('submit' => '#', 'params' => array('id' => $model->id))); ?>
	</div>

<?php $this->endWidget(); ?>

</div>