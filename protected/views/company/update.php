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

<div class="form">

<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'company-form',
	'enableClientValidation' => true,
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data',
		'autocomplete' => 'off',
	)
)); ?>

<?php $this->widget('CTabView',array(
    'activeTab' => 'tab1',
    'tabs'=>array(
        'tab1'=>array(
            'title' => 'Details Company',
            'content' => $this->renderPartial('_form', array('model' => $model, 'form' => $form), true)
        ),
        'tab2'=>array(
            'title' => 'User Company',
            'content' => $this->renderPartial('_user', array('model' => $model->_user, 'form' => $form), true)
        ),
    ),
)); ?>

<div class="row buttons">
	<?php echo CHtml::button($model->isNewRecord ? 'Create' : 'Save', array('submit' => '#', 'params' => array('id' => $model->id))); ?>
</div>


<?php $this->endWidget(); ?>

</div>