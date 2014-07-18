<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo echo $form->labelEx($model, 'name', array('class' => '', 'for' => 'User_name'));; ?>
		<?php echo echo $form->passwordField($model, 'name', array('class' => '', 'placeholder' => Yii::t('models.User', 'input.name'), 'maxlength' => 100));; ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo echo $form->labelEx($model, 'username', array('class' => '', 'for' => 'User_username'));; ?>
		<?php echo echo $form->passwordField($model, 'username', array('class' => '', 'placeholder' => Yii::t('models.User', 'input.username'), 'maxlength' => 32));; ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo echo $form->labelEx($model, 'password', array('class' => '', 'for' => 'User_password'));; ?>
		<?php echo echo $form->passwordField($model, 'password', array('class' => '', 'placeholder' => Yii::t('models.User', 'input.password'), 'maxlength' => 72));; ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row">
		<?php echo echo $form->labelEx($model, 'active', array('class' => '', 'for' => 'User_active'));; ?>
		<?php echo echo $form->checkBox($model, 'active', array('class' => ''));; ?>
		<?php echo $form->error($model,'active'); ?>
	</div>

	<div class="row">
		<?php echo echo $form->labelEx($model, 'date_create', array('class' => '', 'for' => 'User_date_create'));; ?>
		<?php echo 
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
 'model' => $model, 
 'attribute' => 'date_create', 
 'language' => Yii::app()->language, 
 'options' => array('changeMonth' => 'true', 'changeYear' => 'true', ), 
 'htmlOptions' => array('class' => '', 'maxlength' => 10, 'placeholder' => Yii::t('base', 'DD/MM/YYYY')), 
));
; ?>
		<?php echo $form->error($model,'date_create'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->