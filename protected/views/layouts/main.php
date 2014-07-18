<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<?php require_once dirname(__FILE__) . '/header.php';?>

<body>

    <?php if (!in_array($this->action->getId(), array("login"))):?>
    <?php require_once dirname(__FILE__) . '/navbar.php';?>
    <?php require_once dirname(__FILE__) . '/navmenu.php';?>
    <?php endif;?>

	<?php echo $content; ?>

	<?php require_once dirname(__FILE__) . '/footer.php';?>

</body>
</html>
