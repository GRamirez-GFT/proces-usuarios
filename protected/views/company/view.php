<?php
$this->breadcrumbs = array(
	'Companies' => array('index'),
	$model->name,
);

$this->menu = array(
  array('label' => 'List Company', 'url' => array('index')),
  array('label' => 'Create Company', 'url' => array('create')),
  array('label' => 'Update Company', 'url' => '#', 'linkOptions' => array('submit' => array('update'), 'params' => array('id' => $model->id))),
  array('label' => 'Delete Company', 'url' => '#', 'linkOptions' => array('submit' => array('delete'), 'params' => array('id' => $model->id), 'confirm' => Yii::t('zii', 'Are you sure you want to delete this item?'))),
  array('label' => 'Manage Company', 'url' => array('admin')),
);
?>

<h1>View Company #<?php echo $model->id; ?></h1>


<?php
$products = "<ul>";
foreach ($model->products1 as $item) {
    $products .= "<li>{$item->name}</li>";
}
$products .= "</ul>";
?>

<?php $this->widget('CTabView',array(
    'activeTab' => 'tab1',
    'tabs'=>array(
        'tab1'=>array(
            'title' => 'Details Company',
            'content' => $this->widget('zii.widgets.CDetailView', array(
                'data' => $model,
                'attributes' => array(
                    'name',
                    'subdomain',
                    array(
                        'name' => 'user_id',
                        'value' => $model->user_id ? $model->user->name : null
                    ),
                    'active',
                    'date_create',
                    array(
                        'name' => 'list_products',
                        'type' => 'raw',
                        'value' => $products
                    ),
                ),
            ), true)
        ),
        'tab2'=>array(
            'title' => 'User Company',
            'content' => $this->widget('zii.widgets.CDetailView', array(
                'data' => $model->user,
                'attributes' => array(
                    'name',
                    'username',
                ),
            ), true)
        ),
    ),
)); ?>
