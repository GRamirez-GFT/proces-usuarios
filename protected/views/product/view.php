<?php
$this->breadcrumbs = array(
	'Products' => array('index'),
	$model->name,
);

$this->menu = array(
  array('label' => 'List Product', 'url' => array('index')),
  array('label' => 'Create Product', 'url' => array('create')),
  array('label' => 'Update Product', 'url' => '#', 'linkOptions' => array('submit' => array('update'), 'params' => array('id' => $model->id))),
  array('label' => 'Delete Product', 'url' => '#', 'linkOptions' => array('submit' => array('delete'), 'params' => array('id' => $model->id), 'confirm' => Yii::t('zii', 'Are you sure you want to delete this item?'))),	
  array('label' => 'Manage Product', 'url' => array('admin')),
);
?>

<h1>View Product #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
		'name',
		'url_product',
		array(
			'name' => 'company_id',
			'value' => $model->company_id ? $model->company->name : null
		),
	),
));