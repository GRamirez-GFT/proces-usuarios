<?php
$this->breadcrumbs = array(
	'Products' => array('index'),
	$model->name => array('view','id' => $model->id),
	'Update',
);

$this->menu = array(
  array('label' => 'List Product', 'url' => array('index')),
  array('label' => 'Create Product', 'url' => array('create')),
  array('label' => 'View Product', 'url' => array('view', 'id' => $model->id)),
  array('label' => 'Delete Product', 'url' => '#', 'linkOptions' => array('submit' => array('delete'), 'params' => array('id' => $model->id), 'confirm' => Yii::t('zii', 'Are you sure you want to delete this item?'))),	
  array('label' => 'Manage Product', 'url' => array('admin')),
);
?>

<h1>Update Product <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>