<?php $this->beginContent('//layouts/main'); ?>

<div class="ajax-loader"><span class="fa fa-spinner fa-spin"></span></div>

<?php if ($this->menu): ?>

	<div class="container-fluid">

	    <div id="column1" class="col-sm-10">
	    <?php echo $content; ?>
	    </div>
	    
	    <div id="column2" class="col-sm-2">
	    <h5><?php echo Yii::t('base', 'options'); ?></h5>
	    <?php $this->widget('zii.widgets.CMenu', array('items' => $this->menu)); ?>
	    </div>
	</div>

<?php else: ?>

	<div class="content container-fluid">
	    <?php echo $content; ?>
	</div>

<?php endif; ?>

<?php $this->endContent();?>

