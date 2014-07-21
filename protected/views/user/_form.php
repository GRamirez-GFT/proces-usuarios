<div><h3>Crear Usuario</h3></div>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'user-form',
    'enableClientValidation' => true,
    'action' => $model->isNewRecord ? array('create') : array('update'),
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
        'autocomplete' => 'off',
))); ?>

    <div class="cols" data-cols="4">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('maxlength' => 100)); ?>
    </div>

    <div class="cols" data-cols="4">
        <?php echo $form->labelEx($model, 'username'); ?>
        <?php echo $form->textField($model, 'username', array('maxlength' => 32)); ?>
    </div>

    <div class="cols" data-cols="4">
        <?php echo $form->labelEx($model, 'password'); ?>
        <?php echo $form->passwordField($model, 'password', array('maxlength' => 72)); ?>
    </div>

    <div class="cols" data-cols="4">
        <?php echo $form->labelEx($model, 'active'); ?>
        <?php echo $form->checkBox($model, 'active'); ?>
    </div>
    
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Agregar' : 'Modificar', array('class' => 'redbtn')); ?>

<?php $this->endWidget(); ?>