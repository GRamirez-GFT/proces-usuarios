<?php
$this->beginContent('//layouts/main');
$this->widget('zii.widgets.CBreadcrumbs',
    array(
        'separator' => '<span class="separator"> > </span>',
        'links' => $this->breadcrumbs,
        'homeLink' => CHtml::link(Yii::t('site/Home', 'Inicio'), Yii::app()->homeUrl)
    ));
echo $content;
$this->endContent();

