<?php
    $this->breadcrumbs = array(
        Yii::t('base', 'Products') => array(
            'admin'
        ),
        Yii::t('base', 'Manage')
    );
?>

<div class="col-md-4">
    <h1><?php echo Yii::t('base', 'Products'); ?></h1>
</div>

<div class="col-sm-2 pull-right">

<?php
    $linkContent  = '<span class="fa fa-plus-circle" style="margin-right: 8px;"></span>';
    $linkContent .= Yii::t('base', 'Create new');

    echo CHtml::link($linkContent, Yii::app()->createAbsoluteUrl('product/create'), array(
        'class' => 'btn btn-proces-red btn-block  panel-trigger',
        'style' => 'width: auto;'
    ));
?>

</div>

<div class="col-sm-12">

<?php
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'product-grid',
		    'dataProvider' => $model->search(),
		    'template' => '{items}',
		'columns'=>array(
			'name',
		    'token',
            array(
                'class' => 'CButtonColumn',
                'template' => '{view}',
                'buttons' => array(
                    'view' => array(
                        'label' => '',
                        'imageUrl' => '',
                        'options' => array(
                            'title' => Yii::t('zii', 'View'),
                            'class' => 'btn phantom-btn btn-proces-white fa fa-chevron-right panel-trigger',
                            'style' => 'color: #878787;',
                        )
                    ),
                )
            )
		),
	));
?>

</div>