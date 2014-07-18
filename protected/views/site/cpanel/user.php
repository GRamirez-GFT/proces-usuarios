<?php
$documents = array();
$documents[] = array(
    'label' => Yii::t('Document', 'View Documents'),
    'url' => array(
        'document/view'
    )
);
$compromise = array();
$compromises[] = array(
    'label' => Yii::t('Agreement', 'Manage Agreements'),
    'url' => array(
        'agreement/admin'
    )
);
$compromises[] = array(
    'label' => Yii::t('Compromise', 'Manage Compromises'),
    'url' => array(
        'compromise/admin'
    )
);
$indicator = array();
$indicators[] = array(
    'label' => Yii::t('Indicator', 'Manage Indicators'),
    'url' => array(
        'indicator/admin'
    )
);
$menu = array();
$this->beginWidget('Portlet',
    array(
        'title' => Yii::t('ControlPanel', 'Documents'),
        'hidden' => '0',
        'id' => 'documents'
    ));
$this->widget('zii.widgets.CMenu',
    array(
        'items' => $documents,
        'htmlOptions' => array(
            'class' => 'operations'
        )
    ));
$this->endWidget();
$this->beginWidget('Portlet',
    array(
        'title' => Yii::t('ControlPanel', 'Compromises'),
        'hidden' => '0',
        'id' => 'compromises'
    ));
$this->widget('zii.widgets.CMenu',
    array(
        'items' => $compromises,
        'htmlOptions' => array(
            'class' => 'operations'
        )
    ));
$this->endWidget();
$this->beginWidget('Portlet',
    array(
        'title' => Yii::t('ControlPanel', 'Indicators'),
        'hidden' => '0',
        'id' => 'indicators'
    ));
$this->widget('zii.widgets.CMenu',
    array(
        'items' => $indicators,
        'htmlOptions' => array(
            'class' => 'operations'
        )
    ));
$this->endWidget();
?>