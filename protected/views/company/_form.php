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
	<?php echo $form->labelEx($model, 'url_logo'); ?>
	<?php echo $form->fileField($model, 'url_logo'); ?>
	<?php echo $form->error($model, 'url_logo'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model, 'list_products'); ?>
	<?php echo $form->listBox($model, 'list_products',
	    CHtml::listData(Product::model()->findAll(array('condition' => 'company_id IS NULL')), 'id', 'name'),
	    array('multiple' => true)); ?>
	<?php echo $form->error($model, 'list_products'); ?>
</div>
