<div id="login">

	<div id="login-wrapper">
		<div id="logo-login"></div>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<div id="inputs-login">

		<?php echo $form->textField($model, 'username', array('placeholder' => $model->getAttributeLabel('username'))); ?>

		<?php echo $form->passwordField($model, 'password', array('placeholder' => $model->getAttributeLabel('password'))); ?>

		<hr>
		<!-- OCULTAR CUANDO ESTE UBICADO EN SUBDOMINIO -->
		<?php echo $form->textField($model, 'company', array('placeholder' => $model->getAttributeLabel('company'))); ?>

	</div>

	<?php echo CHtml::submitButton(Yii::t('site/Session', 'Login')); ?>

<?php $this->endWidget(); ?>

	</div>

</div>