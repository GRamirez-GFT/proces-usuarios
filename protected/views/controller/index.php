<?php
/* @var $this ControllerController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Controllers',
);

$this->menu=array(
	array('label'=>'Create Controller', 'url'=>array('create')),
	array('label'=>'Manage Controller', 'url'=>array('admin')),
);
?>

<h1>Controllers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
