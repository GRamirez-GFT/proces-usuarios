<?php
$this->breadcrumbs = array(
	'Controllers' => array('index'),
	'Create',
);

$this->menu = array(
  array('label' => 'List Controller', 'url' => array('index')),
  array('label' => 'Manage Controller', 'url' => array('admin')),
);
?>

<h1>Create Controller</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>