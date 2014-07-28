<?php
$this->breadcrumbs = array(
	'Users' => array('index'),
	$model->name,
);

$this->menu = array(
  array('label' => 'List User', 'url' => array('index')),
  array('label' => 'Create User', 'url' => array('create')),
  array('label' => 'Update User', 'url' => '#', 'linkOptions' => array('submit' => array('update'), 'params' => array('id' => $model->id))),
  array('label' => 'Delete User', 'url' => '#', 'linkOptions' => array('submit' => array('delete'), 'params' => array('id' => $model->id), 'confirm' => Yii::t('zii', 'Are you sure you want to delete this item?'))),	
  array('label' => 'Manage User', 'url' => array('admin')),
);
?>

<h1>View User #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'name',
		'username',
		'active',
		'date_create',
		array(
			'name' => 'company_id',
			'value' => $model->company_id ? $model->company->name : null
		),
	),
));