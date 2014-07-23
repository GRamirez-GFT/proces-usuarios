<?php
$this->breadcrumbs=array(
	'Controllers'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Controller', 'url'=>array('index')),
	array('label'=>'Create Controller', 'url'=>array('create')),
);

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'controller-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'url_controller',
		'product_id',
		array(
			'class'=>'CButtonColumn',
		),
	),
));