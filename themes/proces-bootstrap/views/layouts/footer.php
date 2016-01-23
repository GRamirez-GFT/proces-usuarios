<?php
$footer[] = array('label' => Yii::t('base', 'Privacy'), 'url' => Yii::app()->homeUrl);
$footer[] = array('label' => Yii::t('base', 'Manual'), 'url' => Yii::app()->homeUrl);
$footer[] = array('label' => Yii::t('base', 'Contact'), 'url' => Yii::app()->homeUrl);
?>

<div class="footer container-fluid center-block">

    <div class="pull-left col-sm-5">
        &copy; <?php echo date('Y'); ?> por Proces. Todos los derechos reservados.
    </div>
    
    <div class="pull-right col-sm-7">

        <ul class="list-inline">
        	<?php foreach ($footer as $counter => $item):?>
            	   
                <?php echo CHtml::tag('li', array('style' => 'text-align: center;'),
            	CHtml::link($item['label'], $item['url'])); ?>
        	    
                <?php if($counter < (sizeof($footer)-1)): ?>

                    <?php echo CHtml::tag('li', array('style' => 'text-align: center;'), '|'); ?>

                <?php endif;?>

    		<?php endforeach;?>
        </ul>

    </div>

</div> <!-- ENDS FOOTER -->
