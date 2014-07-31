<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
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

	<?php if (Yii::app()->user->role != 'general'):?>
	<div class="row">
		<?php echo $form->labelEx($model, 'username'); ?>
		<?php echo $form->textField($model, 'username', array('maxlength' => 32)); ?>
		<?php echo $form->error($model, 'username'); ?>
	</div>
	<?php endif;?>

	<div class="row">
		<?php echo $form->labelEx($model, 'password'); ?>
		<?php echo $form->passwordField($model, 'password', array('maxlength' => 72)); ?>
		<?php echo $form->error($model, 'password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'verify_password'); ?>
		<?php echo $form->passwordField($model, 'verify_password', array('maxlength' => 72)); ?>
		<?php echo $form->error($model, 'verify_password'); ?>
	</div>

	<?php if (Yii::app()->user->role == 'global'):?>
	<div class="row">
		<?php echo $form->labelEx($model, 'company_id'); ?>
		<?php echo $form->dropDownList($model, 'company_id', CHtml::listData(Company::model()->findAll(), 'id', 'name'), array('prompt' => Yii::t('base', 'select option'))); ?>
		<?php echo $form->error($model, 'company_id'); ?>
	</div>
	<?php endif; ?>

	<?php if (Yii::app()->user->role != 'general'):?>
	<div class="row">
		<?php echo $form->labelEx($model, 'active'); ?>
		<?php echo $form->checkBox($model, 'active'); ?>
		<?php echo $form->error($model, 'active'); ?>
	</div>

	<div class="row">
	    <?php echo $form->labelEx($model, 'list_products'); ?>
		<?php echo $form->listBox($model, 'list_products',
		    CHtml::listData(Product::model()->with(array(
	          'companies' => array(
		          'condition' => "company_id={$model->company_id}"
            )))->findAll(), 'id', 'name'),
		    array('multiple' => true)); ?>
		<?php echo $form->error($model, 'list_products'); ?>
	</div>
	<?php endif; ?>

	<div class="row buttons">
		<?php echo CHtml::button($model->isNewRecord ? 'Create' : 'Save', array('submit' => '#', 'params' => array('id' => $model->id))); ?>
	</div>

<?php $this->endWidget(); ?>

</div>