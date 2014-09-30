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
			<?php echo $form->labelEx($model, 'subdomain'); ?>
			<?php echo $form->textField($model, 'subdomain', array('maxlength' => 30)); ?>
			<?php echo $form->error($model, 'subdomain'); ?>
		</div>
		
	</div>
<?php endif; ?>

</div>

<div class="row">

	<div class="col-md-3">

		<div class="form-group">
			<?php echo $form->labelEx($model, 'url_logo'); ?>
			<div class="upload-input btn btn-proces-white btn-block">
				<span class="fa fa-cloud-upload"></span>
				<?php echo $form->fileField($model, 'url_logo'); ?>
		    </div>
			<?php echo $form->error($model, 'url_logo'); ?>
		</div>

	</div>

<?php if(in_array(Yii::app()->user->role, array('global'))): ?>
	<div class="col-md-3">

		<div class="form-group">
		    <?php echo $form->labelEx($model, 'list_products'); ?>
			<?php echo $form->listBox($model, 'list_products',
			    CHtml::listData(Product::model()->findAll(array('condition' => 'company_id IS NULL')), 'id', 'name'),
			    array('multiple' => true)); ?>
			<?php echo $form->error($model, 'list_products'); ?>
		</div>
		
	</div>
<?php endif; ?>
	
</div>

