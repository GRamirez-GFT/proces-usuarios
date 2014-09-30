<?php
    $controlPanelMenu = array();

    if (in_array(Yii::app()->user->getState('role'), array("company"))) {
        $controlPanelMenu[] = array('label' => Yii::t('base', 'Company profile'), 
                                    'url' => Yii::app()->createAbsoluteUrl('company/view?id='.Yii::app()->user->getState('company_id')),
                                    );
    }
?>

<div class="navbar navbar-head">

	<div class="container-fluid info-bar">

        <div class="navbar-left">
            <?php echo CHtml::image($this->assets . "/img/logo.png", Yii::app()->name, array('class' => 'navbar-brand')); ?>
        </div>


        <?php $this->widget('zii.widgets.CBreadcrumbs',
            array(
                'links' => $this->breadcrumbs,
                'homeLink' => CHtml::link(Yii::t('base', 'Home'), Yii::app()->homeUrl),
        )); ?>

        <a href="<?php echo Yii::app()->createAbsoluteUrl('site/logout'); ?>" class="navbar-right btn-logout">
            <span class="fa fa-logout"></span>
        </a>

<?php if (!empty($controlPanelMenu)) :?>
        <div class="control-panel-container navbar-right">

            <a href="javascript:;" class="btn btn-proces-white button_switch phantom-btn control-panel-button fa fa-cog"></a>

            <div class="drop-list">
                <ul>
                    <?php foreach ($controlPanelMenu as $item):?>
                    <?php echo CHtml::tag('li', array(), CHtml::link($item['label'], $item['url'])); ?>
                    <?php endforeach;?>
                </ul>
                <span class="arrow"></span>
            </div>

        </div>
<?php endif;?>

        <?php if(Yii::app()->user->getState('url_logo')): ?>
        <div class="navbar-right company-logo">
            <?php echo CHtml::image(Yii::app()->user->getState('url_logo'),
                Yii::app()->user->getState("company")); ?>
        </div>
        <?php endif; ?>

        <div class="navbar-right user-info">
            <p class="company-name"><?php echo Yii::app()->user->getState("company"); ?></p>
            <p class="user-name"><?php echo Yii::app()->user->name; ?></p>
        </div>

	</div> <!-- ENDS INFO-BAR -->
