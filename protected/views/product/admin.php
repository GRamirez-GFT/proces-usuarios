<?php
$this->breadcrumbs = array(
	'Products' => array('index'),
	'Manage',
);

$this->menu = array(
	array('label' => 'List Product', 'url' => array('index')),
	array('label' => 'Create Product', 'url' => array('create')),
);

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'product-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'name',
		'url_product',
		array(
			'name' => 'company_id',
			'value' => '$data->company_id ? $data->company->name : null',
		    'filter' => CHtml::activeDropDownList($model, 'company_id',
		        CHtml::listData(Company::model()->findAll(), 'id', 'name'),
		        array('prompt' => Yii::t('base', 'select option'))),
		    'visible' => in_array(Yii::app()->user->role, array("global")),
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
));