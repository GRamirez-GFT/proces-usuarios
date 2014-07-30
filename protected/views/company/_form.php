<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
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
		<?php echo $form->labelEx($model, 'user_id'); ?>
		<?php echo $form->dropDownList($model, 'user_id',
		    CHtml::listData(User::model()->findAllByAttributes(array('company_id' => $model->id)), 'id', 'name'),
		    array('prompt' => Yii::t('base', 'select option'))); ?>
		<?php echo $form->error($model, 'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'active'); ?>
		<?php echo $form->checkBox($model, 'active'); ?>
		<?php echo $form->error($model, 'active'); ?>
	</div>

	<div class="row">
	    <?php echo $form->labelEx($model, 'list_products'); ?>
		<?php echo $form->listBox($model, 'list_products',
		    CHtml::listData(Product::model()->findAll(), 'id', 'name'),
		    array('multiple' => true)); ?>
		<?php echo $form->error($model, 'list_products'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::button($model->isNewRecord ? 'Create' : 'Save', array('submit' => '#', 'params' => array('id' => $model->id))); ?>
	</div>

<?php $this->endWidget(); ?>

</div>