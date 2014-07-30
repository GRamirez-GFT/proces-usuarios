<?php
$this->breadcrumbs = array(
	'Controllers' => array('index'),
	'Manage',
);

$this->menu = array(
	array('label' => 'List Controller', 'url' => array('index')),
	array('label' => 'Create Controller', 'url' => array('create')),
);

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'controller-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'name',
		'url_controller',
		array(
			'name' => 'product_id',
			'value' => '$data->product_id ? $data->product->name : null'
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
));