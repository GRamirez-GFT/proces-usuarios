<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
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
		<?php echo $form->error($model, 'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'url_controller'); ?>
		<?php echo $form->textField($model, 'url_controller', array('maxlength' => 255)); ?>
		<?php echo $form->error($model, 'url_controller'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'product_id'); ?>
		<?php echo $form->dropDownList($model, 'product_id', CHtml::listData(Product::model()->findAll(), 'id', 'name'), array('prompt' => Yii::t('base', 'select option'))); ?>
		<?php echo $form->error($model, 'product_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::button($model->isNewRecord ? 'Create' : 'Save', array('submit' => '#', 'params' => array('id' => $model->id))); ?>
	</div>

<?php $this->endWidget(); ?>

</div>