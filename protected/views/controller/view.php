<?php
$this->breadcrumbs=array(
	'Controllers'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Controller', 'url'=>array('index')),
	array('label'=>'Create Controller', 'url'=>array('create')),
	array('label'=>'Update Controller', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Controller', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete', 'id'=>$model->id), 'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Controller', 'url'=>array('admin')),
);
?>

<h1>View Controller #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'name',
		'url_controller',
		'product_id',
	),
));