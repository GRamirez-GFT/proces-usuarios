<?php
$options = array(); ?>
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
	<div id="options">
		<ul>
			<li><a id="notifications-icon" class="button_switch" href=""> <span>3</span>
			</a>
				<div class="drop-top">
					<ul>
						<li>Notificación</li>
						<li>Notificación</li>
						<li>Notificación</li>
					</ul>
					<span></span>
				</div></li>
			<li><a id="settings-icon" class="button_switch" href=""></a>
				<div class="drop-top">
					<ul>
<?php foreach ($options as $label => $url): ; ?>
    <li><a href="<?php echo Yii::app()->createAbsoluteUrl($url); ?>"><?php echo $label; ?></a></li>
<?php endforeach; ?>
					</ul>
					<span></span>
				</div></li>
		</ul>
	</div>
	<div id="company-logo">
		<img src="<?php echo $this->assets; ?>/img/company-logo.png">
	</div>
	<div id="user">
		<div id="company">
			<?php echo  Yii::app()->user->getState('company'); ?>
		</div>
		<div id="user-name">
			<?php echo Yii::app()->user->name; ?>
		</div>
	</div>
</div>