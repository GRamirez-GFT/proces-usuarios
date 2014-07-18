<?php
// TODO: EVALUAR COMPONENTE
class CCustom {

    public function itemMenu($label, $url = "#", $class = '') {
        return array(
            'label' => '<div></div><p>' . $label . '</p>',
            'url' => $url,
            'linkOptions' => array(
                'class' => $class
            )
        );
    }

    public function checkBox($model, $attribute, $class, $htmlOptions = array()) {
        Yii::app()->clientScript->registerScript('checkbox',
            "
            $('.checkbox').click(function(){
                if($(this).children('input').is(':checked'))
                    $(this).children('span').addClass('checked');
                else
                    $(this).children('span').removeClass();
            });
            ");
        return '<span class="' .
             $class .
             '">' .
             CHtml::activeCheckBox($model, $attribute, $htmlOptions) .
             '<span></span></span>';
    }

    public function checkBoxList($model, $attribute, $data, $class = '') {
        $htmlOptions = array(
            'template' => '<div class="checkbox">{input}<span></span></div>{label}',
            'separator' => ''
        );
        return CHtml::checkBoxList($model, $attribute, $data, $htmlOptions);
    }
    /*
     * $model = Document $box = permissiondepartments
     */
    public function checkBoxListI($model, $box, $parent, $idparent, $items) {
        $name = $model . "[" . $box . "][]";
        $baseID = CHtml::getIdByName($name);
        $templateItem = '<div id="' . $model . '_' . $box .
             '_{iddepartment}"><div class="checkbox">{input}<span></span></div>{label}</div>';
        $departmentsitems = "";
        $id = 0;
        $checked = false;
        $templateContent = '<div id="' .
             $model .
             '_' .
             $box .
             '_' .
             $parent .
             '_{' .
             $idparent .
             '}">{content_' .
             $parent .
             '}</div>';
        $content = "";
        $idbefore = 0;
    }

    public function contentParentCheckBoxList($model, $box, $parent, $idparent, $id, $content) {
        $templateParent = '<div id="' .
             $model .
             '_' .
             $box .
             '_' .
             $parent .
             '_{' .
             $idparent .
             '}">{content_' .
             $parent .
             '}</div>';
        return strtr($templateParent,
            array(
                '{' . $idparent . '}' => $id,
                '{content_' . $parent . '}' => $content
            ));
    }

    public function contentCheckBoxList($model, $box, $idbox, $id, $value, $label, $checked, $filter) {
        $name = $model . '[' . $box . '][]';
        $baseID = CHtml::getIdByName($name);
        $template = '<div id="' . $model . '_' . $box . '_{' . $idbox .
             '}" class="{filter}_checkbox_filter"><div class="checkbox">{input}<span></span></div>{label}</div>';
        $htmlOptions['id'] = $baseID . '_' . $id;
        $htmlOptions['value'] = $value;
        $option = CHtml::checkBox($name, $checked, $htmlOptions);
        $label = CHtml::label($label, $htmlOptions['id'], $labelOptions);
        return strtr($template,
            array(
                '{' . $idbox . '}' => $value,
                '{input}' => $option,
                '{label}' => $label,
                '{filter}' => $filter
            ));
    }

    public function fileField($model, $attribute, $class, $htmlOptions = array()) {
        return '<div class="' .
             $class .
             '">' .
             CHtml::activeFileField($model, $attribute, $htmlOptions) .
             '<span></span></div>';
    }

    public function getTheme() {
        return "default";
    }

}