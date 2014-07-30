<?php
$this->breadcrumbs = array(
	'Companies' => array('index'),
	'Manage',
);

$this->menu = array(
	array('label' => 'List Company', 'url' => array('index')),
	array('label' => 'Create Company', 'url' => array('create')),
);

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'company-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'name',
		'subdomain',
		array(
			'name' => 'user_id',
			'value' => '$data->user_id ? $data->user->name : null'
		),
		'active',
		'date_create',
		array(
			'class'=>'CButtonColumn',
		),
	),
));