<?php
    $this->breadcrumbs = array(
        Yii::t('base', 'Companies') => array('admin'),
        Yii::t('base', 'Create'),
    );
?>

<h1><?php echo Yii::t('base', 'Create').' '.Yii::t('models/Company', 'id'); ?></h1>

<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'company-form',
	'enableClientValidation' => true,
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data',
		'autocomplete' => 'off',
	),
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'beforeValidate' => 'js:function(form) {
        
            form.find(":submit").attr("disabled", "disabled");
            $(".ajax-loader").fadeIn("fast");

            return true;
        }',
        'afterValidate' => 'js:function(form, data, hasError) {
            
            if(hasError) {
                form.find(":submit").removeAttr("disabled");
                $(".ajax-loader").fadeOut("fast");
            } else {
                form.find(":submit").removeAttr("disabled");
            }
            
            return true;
        }',
    )
)); ?>

<?php $this->widget('CTabView',array(
    'activeTab' => 'tab1',
    'htmlOptions' => array(
        'class' => 'proces-tab',
    ),
    'tabs'=>array(
        'tab1'=>array(
            'title' => Yii::t('base', 'Details'),
            'content' => $this->renderPartial('_form', array('model' => $model, 'form' => $form), true)
        ),
        'tab2'=>array(
            'title' => Yii::t('models/User', 'id'),
            'content' => $this->renderPartial('_user', array('model' => $model->user, 'form' => $form), true)
        ),
    ),
)); ?>

<div class="row buttons" style="margin-top: 30px;">

    <div class="col-md-3">
        <?php echo CHtml::submitButton(Yii::t('base', $model->isNewRecord ? 'Create' : 'Save'), 
                                        array('class' => 'btn btn-proces-red btn-block')); ?>
    </div>

    <div class="col-md-3">
        <?php echo CHtml::link(Yii::t('base', 'Cancel'), 
                                $this->createAbsoluteUrl('company/admin'), 
                                array('class'=> 'btn btn-proces-white btn-block cancel-button')); ?>
    </div>

</div>

<?php $this->endWidget(); ?>

</div>
