<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo echo $form->numberField($model, 'id', array('class' => '', 'placeholder' => Yii::t('models.User', 'input.id')));; ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo echo $form->passwordField($model, 'name', array('class' => '', 'placeholder' => Yii::t('models.User', 'input.name'), 'maxlength' => 100));; ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'username'); ?>
		<?php echo echo $form->passwordField($model, 'username', array('class' => '', 'placeholder' => Yii::t('models.User', 'input.username'), 'maxlength' => 32));; ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'active'); ?>
		<?php echo echo $form->checkBox($model, 'active', array('class' => ''));; ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_create'); ?>
		<?php echo 
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
 'model' => $model, 
 'attribute' => 'date_create', 
 'language' => Yii::app()->language, 
 'options' => array('changeMonth' => 'true', 'changeYear' => 'true', ), 
 'htmlOptions' => array('class' => '', 'maxlength' => 10, 'placeholder' => Yii::t('base', 'DD/MM/YYYY')), 
));
; ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->