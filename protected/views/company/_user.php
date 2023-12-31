<div class="row">

	<div class="col-md-3">

		<div class="form-group">
			<?php echo $form->labelEx($model, 'name'); ?>
			<?php echo $form->textField($model, 'name', array('maxlength' => 100)); ?>
			<?php echo $form->error($model, 'name'); ?>
		</div>

	</div>
<?php if(in_array(Yii::app()->user->role, array('global'))): ?>
	<div class="col-md-3">

		<div class="form-group">
			<?php if (in_array(Yii::app()->user->role, array("global", "company"))):?>
				<?php echo $form->labelEx($model, 'username'); ?>
				<?php echo $form->textField($model, 'username', array('maxlength' => 32)); ?>
				<?php echo $form->error($model, 'username'); ?>
			<?php endif;?>
		</div>
		
	</div>
<?php endif; ?>
	
</div>

<div class="row">

	<div class="col-md-3">

		<div class="form-group">
			<?php echo $form->labelEx($model, 'password'); ?>
			<?php  echo $form->passwordField($model, 'password', array('maxlength' => 72)); ?>
			<?php echo $form->error($model, 'password'); ?>
		</div>

	</div>

	<div class="col-md-3">

		<div class="form-group">
			<?php echo $form->labelEx($model, 'verify_password'); ?>
			<?php  echo $form->passwordField($model, 'verify_password', array('maxlength' => 72)); ?>
			<?php echo $form->error($model, 'verify_password'); ?>
		</div>
		
	</div>
</div>

<div class="row">

	<div class="col-md-3">

		<div class="form-group">
			<?php echo $form->labelEx($model, 'email'); ?>
			<?php echo $form->textField($model, 'email', array('maxlength' => 100)); ?>
			<?php echo $form->error($model, 'email'); ?>
		</div>
	</div>
	
</div>