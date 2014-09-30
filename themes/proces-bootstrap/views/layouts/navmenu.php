<?php
    if(in_array(Yii::app()->user->role, array('global'))) {
    $menu[] = array('label' => Yii::t('base', 'Companies'), 
                                'url' => Yii::app()->createAbsoluteUrl('company'),
                                'icon' => 'fa fa-building',
                                'controller' => 'company'
                                );
    }

    if(in_array(Yii::app()->user->role, array('company'))) {
    $menu[] = array('label' => Yii::t('base', 'Users'), 
                                'url' => Yii::app()->createAbsoluteUrl('user'),
                                'icon' => 'fa fa-users',
                                'controller' => 'user'
                                );
    $menu[] = array('label' => Yii::t('base', 'Products'), 
                                'url' => Yii::app()->createAbsoluteUrl('product'),
                                'icon' => 'fa fa-shopping-cart',
                                'controller' => 'product'
                                );
    }
?>

    <div class="container-fluid menu-bar">

        <ul class="list-inline center-block">
        	<?php foreach ($menu as $item):?>
        	<?php 
        		$icon = isset($item['icon']) ? $item['icon'] : '';
        		$class = 'menu-link mws-tooltip-n '. $icon;

                $elementContent  = '<span class="menu_arrow"></span>';
                $elementContent .= CHtml::link('', $item['url'], array('class' =>  $class, 'original-title' => $item['label']));

	        	echo CHtml::tag('li', array(
                        'class' => $this->uniqueid == $item['controller'] ? 'current' : '',
                    ), 
                    $elementContent); 
        	  ?>
        	<?php endforeach;?>
        </ul>

    </div>


</div> <!-- ENDS NAVHEAD -->