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

<?php if (!$model->isNewRecord):?>
<div class="row">
	<?php echo $form->labelEx($model, 'active'); ?>
	<?php echo $form->checkBox($model, 'active'); ?>
	<?php echo $form->error($model, 'active'); ?>
</div>
<?php endif;?>

<div class="row">
    <?php echo $form->labelEx($model, 'list_products'); ?>
	<?php echo $form->listBox($model, 'list_products',
	    CHtml::listData(Product::model()->findAll(array('condition' => 'company_id IS NULL')), 'id', 'name'),
	    array('multiple' => true)); ?>
	<?php echo $form->error($model, 'list_products'); ?>
</div>
