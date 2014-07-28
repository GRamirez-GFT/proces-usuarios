<?php
$this->breadcrumbs = array(
	'User Types' => array('index'),
	'Create',
);

$this->menu = array(
  array('label' => 'List UserType', 'url' => array('index')),
  array('label' => 'Manage UserType', 'url' => array('admin')),
);
?>

<h1>Create UserType</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>