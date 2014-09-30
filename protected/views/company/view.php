<?php
    $this->breadcrumbs = array(
        Yii::t('base','Companies') => array('admin'),
        $model->name,
    );
?>

<h1><?php echo Yii::t('base', 'Company details') ?></h1>


<?php
$products = "<ul>";
foreach ($model->products1 as $item) {
    $products .= "<li>{$item->name}</li>";
}
$products .= "</ul>";
?>

<div class="col-md-12 <?php echo isset($ajaxRequest) ? 'panel-actions' : ''; ?>" style="margin-bottom:10px;">

<?php
    echo CHtml::link('', Yii::app()->createAbsoluteUrl('Company/update/?id='.$model->id), 
        array(
        'class' => 'btn btn-proces-white phantom-btn fa fa-pencil mws-tooltip-s',
        'original-title' => Yii::t('base','Update')
    ));
    
    if(in_array(Yii::app()->user->getState('role'), array("global"))) {
        echo CHtml::link('', Yii::app()->createAbsoluteUrl('Company/delete/?id='.$model->id), 
            array(
            'class' => 'btn btn-proces-white phantom-btn fa fa-trash mws-tooltip-s confirm-action',
            'original-title' => Yii::t('base','Delete')
        ));
    }
?>
</div>

<?php $this->widget('CTabView',array(
    'activeTab' => 'tab1',
    'htmlOptions' => array(
        'class' => 'proces-tab',
    ),
    'tabs'=>array(
        'tab1'=>array(
            'title' => Yii::t('base', 'Details'),
            'content' =>  $this->renderPartial('_view', array('model' => $model), true)
        ),
        'tab2'=>array(
            'title' => Yii::t('models/User', 'id'),
            'content' => $this->renderPartial('_userDetails', array('model' => $model), true)
        ),
    ),
)); ?>
