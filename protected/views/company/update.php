<?php
$this->breadcrumbs = array(
	'Companies' => array('index'),
	$model->name => array('view','id' => $model->id),
	'Update',
);

$this->menu = array(
  array('label' => 'List Company', 'url' => array('index')),
  array('label' => 'Create Company', 'url' => array('create')),
  array('label' => 'View Company', 'url' => array('view', 'id' => $model->id)),
  array('label' => 'Delete Company', 'url' => '#', 'linkOptions' => array('submit' => array('delete'), 'params' => array('id' => $model->id), 'confirm' => Yii::t('zii', 'Are you sure you want to delete this item?'))),	
  array('label' => 'Manage Company', 'url' => array('admin')),
);
?>

<h1>Update Company <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>