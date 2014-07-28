<?php
$this->breadcrumbs=array(
	'User Types'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List UserType', 'url'=>array('index')),
	array('label'=>'Create UserType', 'url'=>array('create')),
);

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-type-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'product_id',
		'name',
		array(
			'class'=>'CButtonColumn',
		),
	),
));