<?php
$this->breadcrumbs = array(
	'Users' => array('index'),
	$model->name => array('view','id' => $model->id),
	'Update',
);

$this->menu = array(
  array('label' => 'List User', 'url' => array('index')),
  array('label' => 'Create User', 'url' => array('create')),
  array('label' => 'View User', 'url' => array('view', 'id' => $model->id)),
  array('label' => 'Delete User', 'url' => '#', 'linkOptions' => array('submit' => array('delete'), 'params' => array('id' => $model->id), 'confirm' => Yii::t('zii', 'Are you sure you want to delete this item?'))),	
  array('label' => 'Manage User', 'url' => array('admin')),
);
?>

<h1>Update User <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>