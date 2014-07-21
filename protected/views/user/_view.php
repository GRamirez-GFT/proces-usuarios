<div class="panel-info">

	<h3>Detalles Usuario</h3>
	
	<div class="panel_section">
	
<?php $this->widget('zii.widgets.CDetailView', array(
    'id' => 'user-details',
    'cssFile' => false,
    'itemTemplate' => '<div data-cols="4"><p><strong>{label}: </strong> {value}</p></div>',
    'data' => $model,
	'attributes' => array(
        'username',
        'name',
        'active',
	    'date_create',
    ),
));?>
	
    </div>
</div>