<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo Yii::app()->sourceLanguage; ?>" lang="<?php echo Yii::app()->language; ?>">
<?php require_once dirname(__FILE__) . '/header.php';?>
<?php if (in_array($this->action->getId(), array("login"))):?>
<body class="body-login">
    <?php echo $content; ?>
	<div class="footer-login">
       &copy; <?php echo date('Y'); ?> by Proces. Todos los derechos reservados.
	</div>
</body>
<?php else:?>
<body>
    <?php require_once dirname(__FILE__) . '/navhead.php';?>
    <?php require_once dirname(__FILE__) . '/navmenu.php';?>
	<?php echo $content; ?>
	<?php require_once dirname(__FILE__) . '/footer.php';?>
</body>
<?php endif;?>
</html>
