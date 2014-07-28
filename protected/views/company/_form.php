<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'company-form',
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
		<?php echo $form->error($model, 'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'subdomain'); ?>
		<?php echo $form->textField($model, 'subdomain', array('maxlength' => 30)); ?>
		<?php echo $form->error($model, 'subdomain'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'active'); ?>
		<?php echo $form->checkBox($model, 'active'); ?>
		<?php echo $form->error($model, 'active'); ?>
	</div>

	<div class="row">
	    <?php echo $form->labelEx($model, 'list_products'); ?>
		<?php echo $form->listBox($model, 'list_products', CHtml::listData(Product::model()->findAll(), 'id', 'name')); ?>
		<?php echo $form->error($model, 'list_products'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div>