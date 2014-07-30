<?php
$this->breadcrumbs = array(
	'Users' => array('index'),
	'Manage',
);

$this->menu = array(
	array('label' => 'List User', 'url' => array('index')),
	array('label' => 'Create User', 'url' => array('create')),
);

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'name',
		'username',
		array(
			'name' => 'company_id',
			'value' => '$data->company_id ? $data->company->name : null'
		),
		'active',
		'date_create',
		array(
			'class'=>'CButtonColumn',
		),
	),
));