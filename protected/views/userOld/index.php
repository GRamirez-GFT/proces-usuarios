<div id="front" class="content">
    <?php $this->renderPartial('_table', array('model' => $model)); ?>
</div>

<div id="panel" style="display: none; width: 32%">
	<div id="panel-options">
		<div id="close-panel"></div>
	</div>
	<div id="panel-content" class="panel_section">
		<?php $this->renderPartial('_form', array('model' => $model)); ?>
	</div>
</div>