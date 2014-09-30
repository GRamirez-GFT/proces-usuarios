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
    ),
);