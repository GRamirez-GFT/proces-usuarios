<?php
$this->breadcrumbs=array(
	'Controllers'=>array('index'),
	$model->name=>array('view', 'id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Controller', 'url'=>array('index')),
	array('label'=>'Create Controller', 'url'=>array('create')),
	array('label'=>'View Controller', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Controller', 'url'=>array('admin')),
);
?>

<h1>Update Controller <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>