<?php $this->beginContent('//layouts/main'); ?>
<div class="content" style="width: 80%">
	<?php echo $content; ?>
</div>
<div id="panel" style="display: block; width: 16%">
	<div id="panel-content" class="panel_section">
<?php
$this->beginWidget('zii.widgets.CPortlet', array(
    'title' => 'Operations'
));
$this->widget('zii.widgets.CMenu',
    array(
        'items' => $this->menu,
        'htmlOptions' => array(
            'class' => 'operations'
        )
    ));
$this->endWidget();
?>
    </div>
</div>
<?php $this->endContent(); ?>