<?php
$options = array(
    'proyectos',
    'presupuestos',
    'ingresos',
    'pagos',
    'requisicion',
    'orden_compra',
    'gastos_comprobar',
    'reportes',
    'archivos',
    'clima_laboral',
    'grados'
);
?>
<!--
<div id="menu">
	<ul>
<?php foreach ($options as $option): ?>
    <li><a href="<?php echo $option; ?>" class="mws-tooltip-n"
			title="<?php echo $option; ?>"> <span
				id="<?php echo $option; ?>-icon"></span> <span><?php echo $option; ?></span>
		</a></li>
<?php endforeach; ?>
    </ul>
</div>
-->

<?php
$options = array(
    'user' => 'Usuarios',
    'company' => 'Compañías',
    'product' => 'Productos',
);
switch (Yii::app()->user->role) {
    case 'global':
        unset($options['user']);
        break;
    case 'company':
        unset($options['company']);
        break;
    case 'general':
        unset($options['company']);
        unset($options['product']);
        break;
}
?>

<div id="menu">
	<ul>
<?php foreach ($options as $controller => $option): ?>
    <li><?php echo CHtml::link($option, Yii::app()->createAbsoluteUrl($controller)); ?></li>
<?php endforeach; ?>
    </ul>
</div>