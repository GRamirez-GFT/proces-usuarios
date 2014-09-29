
<div id="topbar">
	<div id="logo">
		<a href="<?php Yii::app()->baseUrl; ?>"><img
			src="<?php echo $this->assets; ?>/img/logo.png" alt="proces"></a>
	</div>
	<div id="breadcrums">
		<p>
			<a href="<?php Yii::app()->baseUrl; ?>">Inicio</a>
			<?php if ($this->id != 'site'):; ?>
			<span class="breadcrums-sep"></span>
			<a href="#"><?php echo $this->id; ?></a>
			<?php endif;; ?>
		</p>
	</div>

	<a id="logout"
		href="<?php echo $this->createAbsoluteUrl('site/logout'); ?>"> <span
		id="logout-icon"></span>
	</a>
	<!-- end logout -->
	<?php if(!empty(Yii::app()->user->getState('company'))): ?>
	<div id="company-logo">
		<img src="<?php echo Yii::app()->user->getState('url_logo'); ?>">
	</div>
	<?php endif; ?>

	<div id="user">
		<div id="company">
			<?php echo  Yii::app()->user->getState('company'); ?>
		</div>
		<div id="user-name">
			<?php echo Yii::app()->user->name; ?>
		</div>
	</div>
</div>