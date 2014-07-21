<div id="front" class="content" style="width: 64%">
    <?php $this->renderPartial('_table', array('model' => $model)); ?>
</div>

<div id="panel" style="display: block; width: 32%">
	<div id="panel-options">
		<div id="close-panel"></div>
	</div>
	<div id="panel-content" class="panel_section">
	   <a id="editar-option" class="mws-tooltip-s " original-title="Editar"></a>
	   <?php echo CHtml::link('', '#', array(
	       'id' => 'eliminar-option',
	       'class' => 'mws-tooltip-s',
	       'original-title' => 'Eliminar',
	       'submit' => array('id' => $model->id),
	       'confirm' => 'Are you sure?',
	       'csrf' => true)
	   ); ?>
		<?php $this->renderPartial('_view', array('model' => $model)); ?>
	</div>
</div>