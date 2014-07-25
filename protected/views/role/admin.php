<?php
$this->breadcrumbs=array(
	'Roles'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Role', 'url'=>array('index')),
	array('label'=>'Create Role', 'url'=>array('create')),
);

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'role-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'name',
		array(
		    'name' => 'company_id',
		    'value' => '$data->company->name'
	    ),
	    array(
	        'name' => 'product_id',
	        'value' => '$data->product->name'
	    ),
		array(
			'class'=>'CButtonColumn',
		),
	),
));