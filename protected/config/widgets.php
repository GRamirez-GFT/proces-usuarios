<?php
return array(
    'CActiveForm' => array(
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'errorCssClass' => 'has-error text-danger',
            'successCssClass' => 'has-success',
            'inputContainer' => '.form-group'
        ),
        'htmlOptions' => array(
            'role' => 'form',
            'enctype' => 'multipart/form-data',
            'autocomplete' => 'off'
        )
    ),
    'CBreadcrumbs' => array(
        'separator' => '<span class="fa fa-angle-right separator"></span>',
        'encodeLabel' => false,
        'htmlOptions' => array(
            'class' => 'proces-breadcrumbs navbar-left'
        )
    ),
    'CMenu' => array(
        'htmlOptions' => array(
            'class' => 'nav nav-stacks'
        )
    ),
    'CGridView' => array(
        'itemsCssClass' => 'table table-hover',
        'template' => '<div >{items}</div><div>{pager}</div>',
        'pager' => array(
            'class' => 'CLinkPager', 
            'nextPageCssClass' => 'next-page-proces pager-btn red-pager-btn',
            'previousPageCssClass' => 'previous-page-proces pager-btn red-pager-btn',
            'lastPageCssClass' => 'last-page-proces pager-btn red-pager-btn',
            'firstPageCssClass' => 'first-page-proces pager-btn red-pager-btn',
            'internalPageCssClass' => 'internal-page-proces pager-btn white-pager-btn',
            'selectedPageCssClass' => 'selected-page-proces',
            
            'firstPageLabel' => '<span class="fa fa-arrow-circle-left mws-tooltip-s" original-title="'.Yii::t('base', 'First').'"></span>',
            'lastPageLabel' => '<span class="fa fa-arrow-circle-right mws-tooltip-s" original-title="'.Yii::t('base', 'Last').'"></span>',
            'prevPageLabel' => '<span class="fa fa-arrow-circle-o-left mws-tooltip-s" original-title="'.Yii::t('base', 'Previous').'"></span>',
            'nextPageLabel' => '<span class="fa fa-arrow-circle-o-right mws-tooltip-s" original-title="'.Yii::t('base', 'Next').'"></span>',
        ),
        'beforeAjaxUpdate' => 'js:function(form) {
            $(".ajax-loader").fadeIn("fast");
        }',
        'afterAjaxUpdate' => 'js:function(form, data, hasError) {
            $(".ajax-loader").fadeOut("fast");
            $(".tipsy").remove();
        }',
        'ajaxUpdateError' => 'js:function(form, data, hasError) {
            $(".ajax-loader").fadeOut("fast");
            $(".tipsy").remove();
        }',
    ),
);