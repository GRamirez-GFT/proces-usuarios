<?php if (!in_array($this->action->getId(), array("login"))): ?>
<footer>
	<p>&copy; 2012 por Icono. Todos los derechos reservados</p>
	<ul>
		<li><a href="">Políticas de privacidad</a></li>
		<li><a href="">Manual de usuario</a></li>
		<li><a href="">Contacto</a></li>
	</ul>
</footer>
<?php else: ?>
<div id="login-footer">
	<p>&copy; <?php echo date('Y'); ?> por Icono. Todos los derechos reservados.</p>
</div>
<?php endif; ?>
