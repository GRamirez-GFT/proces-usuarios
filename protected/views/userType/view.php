<?php
$this->breadcrumbs=array(
	'User Types'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List UserType', 'url'=>array('index')),
	array('label'=>'Create UserType', 'url'=>array('create')),
	array('label'=>'Update UserType', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete UserType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UserType', 'url'=>array('admin')),
);
?>

<h1>View UserType #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'product_id',
		'name',
	),
));