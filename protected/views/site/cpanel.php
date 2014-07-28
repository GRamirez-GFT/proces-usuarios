<?php
$this->breadcrumbs = array(
	Yii::t('site/cpanel', 'Panel de Control'),
);
?>
<h1 id="control_panel" style="padding-left: 70px;">
    <?php echo Yii::t('site/cpanel', 'Control Panel'); ?>
</h1>
<?php
	if(Yii::app()->user->checkAccess("user"))
		$this->renderPartial('cpanel/user');
	else
		$this->renderPartial('cpanel/admin');
?>

