<?php 
	$form = $this->beginWidget('CActiveForm', array(
		'id'=>'user-form',
		'enableClientValidation' => false,
		'htmlOptions' => array(
			'enctype' => 'multipart/form-data',
			'autocomplete' => 'off',
			'class' => isset($ajaxRequest) ? 'ajax-submit' : '',
		)
	)); 

	$columnSize = '3';
	$columnSizeLarge = '6';

	if(isset($ajaxRequest)) {
		$columnSize = '6';
		$columnSizeLarge = '12';
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


	<?php if (in_array(Yii::app()->user->role, array("global", "company")) && $model->isNewRecord):?>
	<div class="col-md-<?php echo $columnSize; ?>">

		<div class="form-group">
			<?php echo $form->labelEx($model, 'username'); ?>
			<?php echo $form->textField($model, 'username', array('maxlength' => 32)); ?>
			<?php echo $form->error($model, 'username'); ?>
		</div>

	</div>
	<?php endif;?>

</div>

<div class="row">

	<div class="col-md-<?php echo $columnSize; ?>">

		<div class="form-group">
			<?php echo $form->labelEx($model, 'password'); ?>
			<?php echo $form->passwordField($model, 'password', array('maxlength' => 72)); ?>
			<?php echo $form->error($model, 'password'); ?>
		</div>

	</div>

	<div class="col-md-<?php echo $columnSize; ?>">

		<div class="form-group">
			<?php echo $form->labelEx($model, 'verify_password'); ?>
			<?php echo $form->passwordField($model, 'verify_password', array('maxlength' => 72)); ?>
			<?php echo $form->error($model, 'verify_password'); ?>
		</div>
		
	</div>

</div>

<div class="row">

	<div class="col-md-<?php echo $columnSize; ?>">

		<div class="form-group">
			<?php echo $form->labelEx($model, 'email'); ?>
			<?php echo $form->textField($model, 'email', array('maxlength' => 100)); ?>
			<?php echo $form->error($model, 'email'); ?>
		</div>
		
	</div>

	<?php if (in_array(Yii::app()->user->role, array("global"))):?>
	<div class="col-md-<?php echo $columnSize; ?>">

		<div class="form-group">
			<?php echo $form->labelEx($model, 'company_id'); ?>
			<?php echo $form->dropDownList($model, 'company_id', CHtml::listData(Company::model()->findAll(), 'id', 'name'), 
                    array('prompt' => Yii::t('base', 'select option'))); ?>
			<?php echo $form->error($model, 'company_id'); ?>
		</div>

	</div>
	<?php endif; ?>

</div>

<div class="row">

    <?php 
    $notAdmin = $model->isNewRecord ? true : ($model->company->user_id != $model->id ? true : false);
    if(in_array(Yii::app()->user->role, array("company")) && $notAdmin): ?>
	
	<div class="col-md-<?php echo $columnSizeLarge; ?>">

		<div class="form-group">
		    <?php echo $form->labelEx($model, 'list_products'); ?>
			<?php echo $form->listBox($model, 'list_products',
			    CHtml::listData(Product::model()->with(array(
		          'companies' => array(
			          'condition' => "companies_companies.company_id=".Yii::app()->user->company_id
	            )))->findAll("t.id <> '1'"), 'id', 'name'),
			    array('multiple' => true)); ?>
			<?php echo $form->error($model, 'list_products'); ?>
		</div>

	</div>
	<?php endif; ?>

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