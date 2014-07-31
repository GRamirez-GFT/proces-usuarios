<?php
$this->breadcrumbs = array(
	'Users' => array('index'),
	$model->name => array('view','id' => $model->id),
	'Update',
);

$this->menu = array(
  array('label' => 'List User', 'url' => array('index'), 'visible' => in_array(Yii::app()->user->role, array("global", "company"))),
  array('label' => 'Create User', 'url' => array('create'), 'visible' => in_array(Yii::app()->user->role, array("global", "company"))),
  array('label' => 'View User', 'url' => array('view', 'id' => $model->id)),
  array('label' => 'Delete User', 'url' => '#', 'linkOptions' => array('submit' => array('delete'), 'params' => array('id' => $model->id), 'confirm' => Yii::t('zii', 'Are you sure you want to delete this item?')), 'visible' => in_array(Yii::app()->user->role, array("global", "company"))),
  array('label' => 'Manage User', 'url' => array('admin'), 'visible' => in_array(Yii::app()->user->role, array("global", "company"))),
);
?>

<h1>Update User <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>