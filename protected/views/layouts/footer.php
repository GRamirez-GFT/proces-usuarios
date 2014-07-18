<?php if (!in_array($this->action->getId(), array("login"))):?>
<footer>
	<p>&copy; 2012 por Icono. Todos los derechos reservados</p>
	<ul>
		<li><a href="">Políticas de privacidad</a></li>
		<li><a href="">Manual de usuario</a></li>
		<li><a href="">Contacto</a></li>
	</ul>
</footer>
<?php else:?>
<div id="login-footer">
	<p>&copy; <?=date('Y')?> por Icono. Todos los derechos reservados.</p>
</div>
<?php endif;?>
<!--
<script type="text/javascript" src="<?php echo $this->assets; ?>/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo $this->assets; ?>/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?php echo $this->assets; ?>/js/jquery.numeric.js"></script>
<script type="text/javascript" src="<?php echo $this->assets; ?>/js/fullcalendar.min.js"></script>
<script type="text/javascript" src="<?php echo $this->assets; ?>/js/elfinder.min.js"></script>
<script type="text/javascript" src="<?php echo $this->assets; ?>/js/i18n/elfinder.es.js"></script>
<script type="text/javascript" src="<?php echo $this->assets; ?>/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $this->assets; ?>/js/jquery.tipsy-min.js"></script>
<script type="text/javascript" src="<?php echo $this->assets; ?>/js/excanvas.min.js"></script>
<script type="text/javascript" src="<?php echo $this->assets; ?>/js/jquery.flot.min.js"></script>
<script type="text/javascript" src="<?php echo $this->assets; ?>/js/jquery.flot.pie.min.js"></script>
<script type="text/javascript" src="<?php echo $this->assets; ?>/js/jquery.flot.stack.min.js"></script>
<script type="text/javascript" src="<?php echo $this->assets; ?>/js/jquery.flot.resize.min.js"></script>
<script type="text/javascript" src="<?php echo $this->assets; ?>/js/jquery.jgrowl-min.js"></script>


<script type="text/javascript" src="<?php echo $this->assets; ?>/js/functions.js"></script>
 -->