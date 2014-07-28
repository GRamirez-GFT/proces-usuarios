<?php
$this->breadcrumbs = array(
	'Controllers' => array('index'),
	$model->name => array('view','id' => $model->id),
	'Update',
);

$this->menu = array(
  array('label' => 'List Controller', 'url' => array('index')),
  array('label' => 'Create Controller', 'url' => array('create')),
  array('label' => 'View Controller', 'url' => array('view', 'id' => $model->id)),
  array('label' => 'Delete Controller', 'url' => '#', 'linkOptions' => array('submit' => array('delete'), 'params' => array('id' => $model->id), 'confirm' => Yii::t('zii', 'Are you sure you want to delete this item?'))),	
  array('label' => 'Manage Controller', 'url' => array('admin')),
);
?>

<h1>Update Controller <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>