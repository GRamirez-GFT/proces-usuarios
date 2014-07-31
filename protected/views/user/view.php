<?php
$this->breadcrumbs = array(
	'Users' => array('index'),
	$model->name,
);

$this->menu = array(
  array('label' => 'List User', 'url' => array('index'), 'visible' => in_array(Yii::app()->user->role, array("global", "company"))),
  array('label' => 'Create User', 'url' => array('create'), 'visible' => in_array(Yii::app()->user->role, array("global", "company"))),
  array('label' => 'Update User', 'url' => '#', 'linkOptions' => array('submit' => array('update'), 'params' => array('id' => $model->id))),
  array('label' => 'Delete User', 'url' => '#', 'linkOptions' => array('submit' => array('delete'), 'params' => array('id' => $model->id), 'confirm' => Yii::t('zii', 'Are you sure you want to delete this item?')), 'visible' => in_array(Yii::app()->user->role, array("global", "company"))),
  array('label' => 'Manage User', 'url' => array('admin'), 'visible' => in_array(Yii::app()->user->role, array("global", "company"))),
);
?>

<h1>View User #<?php echo $model->id; ?></h1>

<?php
$products = "<ul>";
foreach ($model->products as $item) {
    $products .= "<li>{$item->name}</li>";
}
$products .= "</ul>";
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
		'name',
		'username',
		array(
			'name' => 'company_id',
			'value' => $model->company_id ? $model->company->name : null
		),
		'active',
		'date_create',
        array(
            'name' => 'list_products',
            'type' => 'raw',
            'value' => $products
        ),
	),
));