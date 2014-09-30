<div class="center-block login-container">

    <div class="col-md-6 logo-container">
        <img class="center-block" src="<?php echo $this->assets; ?>/img/logo-login.png" />
    </div>

    <div class="col-md-6">

        <?php $form = $this->beginWidget('CActiveForm', array(
            'id'=>'login-form',
            'enableClientValidation' => true,
            'htmlOptions' => array(
                'class' => 'login-form',
                'enctype' => 'multipart/form-data',
                )
            )); ?>

            <div class="fields-container">

                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon"><span class="fa fa-user"></span></div>
                        <?php echo $form->textField($model, 'username', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('username'))); ?>
                        <?php echo $form->error($model, 'username', array('class' => 'error-login')); ?>
                	</div>
            	</div>

            	<div class="form-group">
                	<div class="input-group">
                	    <div class="input-group-addon"><span class="fa fa-lock"></span></div>
                	    <?php echo $form->passwordField($model, 'password', array('class' => 'form-control input-login', 'placeholder' => $model->getAttributeLabel('password'))); ?>
                	    <?php echo $form->error($model, 'password', array('class' => 'error-login')); ?>
            	   </div>
            	</div>

            	<?php // TODO: Ocultar cuando se acceda al subdominio ?>
            	<div class="form-group">
                	<div class="input-group">
                        <div class="input-group-addon"><span class="fa fa-suitcase"></span></div>
                        <?php echo $form->textField($model, 'company', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('company'))); ?>
                        <?php echo $form->error($model, 'company', array('class' => 'error-login')); ?>
                	</div>
            	</div>

            </div> <!-- ENDS CONTAINER-LOGIN -->

            <?php echo CHtml::submitButton(Yii::t('base', 'Access'), array('class' => 'btn btn-proces-white btn-block')); ?>

        <?php $this->endWidget(); ?>

    </div>

</div>