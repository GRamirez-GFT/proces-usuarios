<?php
$informations = array();
if (Yii::app()->user->checkAccess("admin")) {
    $informations[] = array(
        'label' => Yii::t('Company', 'Manage Companies'),
        'url' => array(
            'company/admin'
        )
    );
    // $informations[] = array('label' => Yii::t('Permission', 'Manage Permissions'), 'url' =>
// array('permission/admin'));
} else
    $informations[] = array(
        'label' => Yii::t('Company', 'Corporate Information'),
        'url' => array(
            'company/update',
            'id' => Yii::app()->user->getState('company')
        )
    );
$informations[] = array(
    'label' => Yii::t('Area', 'Manage Areas'),
    'url' => array(
        'area/admin'
    )
);
$informations[] = array(
    'label' => Yii::t('Department', 'Manage Departments'),
    'url' => array(
        'department/admin'
    )
);
$informations[] = array(
    'label' => Yii::t('Position', 'Manage Positions'),
    'url' => array(
        'position/admin'
    )
);
$informations[] = array(
    'label' => Yii::t('Employee', 'Manage Employees'),
    'url' => array(
        'employee/admin'
    )
);
$informations[] = array(
    'label' => Yii::t('User', 'Manage Users'),
    'url' => array(
        'user/admin'
    )
);
if (Yii::app()->user->checkAccess("admin")) {
    $informations[] = array(
        'label' => Yii::t('Theme', 'Manage Themes'),
        'url' => array(
            'theme/admin'
        )
    );
    $informations[] = array(
        'label' => Yii::t('CustomTheme', 'Manage Custom Themes'),
        'url' => array(
            'customTheme/admin'
        )
    );
} else
    $informations[] = array(
        'label' => Yii::t('CustomTheme', 'Select Theme'),
        'url' => array(
            'customTheme/theme'
        )
    );
    // $informations[] = array('label' => Yii::t('Theme', 'Manage Themes'), 'url' =>
// array('site/page/manage_themes','view'=>'manage_themes'));
$documents = array();
$documents[] = array(
    'label' => Yii::t('Document', 'Manage Documents'),
    'url' => array(
        'document/admin'
    )
);
$documents[] = array(
    'label' => Yii::t('OldDocument', 'Manage Old Documents'),
    'url' => array(
        'oldDocument/admin'
    )
);
$documents[] = array(
    'label' => Yii::t('Classification', 'Manage Classifications'),
    'url' => array(
        'classification/admin'
    )
);
$compromises = array();
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
$compromises[] = array(
    'label' => Yii::t('Derivative', 'Manage Derivatives'),
    'url' => array(
        'derivative/admin'
    )
);
$compromises[] = array(
    'label' => Yii::t('Status', 'Manage Status'),
    'url' => array(
        'status/admin'
    )
);
$indicators = array();
$indicators[] = array(
    'label' => Yii::t('Indicator', 'Manage Indicators'),
    'url' => array(
        'indicator/admin'
    )
);
// $indicators[] = array('label' => Yii::t('Periodicity', 'Manage Periodicities'),'url' => array('periodicity/admin'));
// $indicators[] = array('label' => Yii::t('Threshold', 'Manage Thresholds'),'url' => array('threshold/admin'));
$this->beginWidget('Portlet',
    array(
        'title' => Yii::t('ControlPanel', 'Information'),
        'hidden' => '1',
        'id' => 'informations'
    ));
$this->widget('zii.widgets.CMenu',
    array(
        'items' => $informations,
        'htmlOptions' => array(
            'class' => 'operations'
        )
    ));
$this->endWidget();
$this->beginWidget('Portlet',
    array(
        'title' => Yii::t('ControlPanel', 'Documents'),
        'hidden' => '1',
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
        'hidden' => '1',
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
        'hidden' => '1',
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