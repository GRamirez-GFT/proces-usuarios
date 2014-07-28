<?php
$this->breadcrumbs = array(
	'User Types' => array('index'),
	$model->name,
);

$this->menu = array(
  array('label' => 'List UserType', 'url' => array('index')),
  array('label' => 'Create UserType', 'url' => array('create')),
  array('label' => 'Update UserType', 'url' => '#', 'linkOptions' => array('submit' => array('update'), 'params' => array('id' => $model->id))),
  array('label' => 'Delete UserType', 'url' => '#', 'linkOptions' => array('submit' => array('delete'), 'params' => array('id' => $model->id), 'confirm' => Yii::t('zii', 'Are you sure you want to delete this item?'))),	
  array('label' => 'Manage UserType', 'url' => array('admin')),
);
?>

<h1>View UserType #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name' => 'product_id',
			'value' => $model->product->name
		),
		'name',
	),
));