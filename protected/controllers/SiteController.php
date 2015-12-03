<?php

class SiteController extends MyController {
    public $layout = '//layouts/content';
    public $defaultAction = 'index';
    
    public function filters() {
        return array(
            'accessControl',
            array('application.filters.GlobalAccessControlFilter - error'),
            'postOnly + delete'
        );
    }
    
    public function accessRules() {
        return CMap::mergeArray(
            array(
                array(
                    'allow',
                    'actions' => array(),
                    'users' => array(
                        '@'
                    )
                ),
                array(
                    'allow',
                    'actions' => array(
                        'login', 'error', 'contact'
                    ),
                    'users' => array(
                        '*'
                    )
                )
            ), parent::accessRules());
    }

    public function actions() {
        return array(
            'index' => 'application.actions.site.IndexAction',
            'login' => 'application.actions.site.LoginAction',
            'logout' => 'application.actions.site.LogoutAction',
            'cpanel' => 'application.actions.site.CpanelAction',
            'contact' => 'application.actions.site.ContactAction',
            'error' => 'application.actions.site.ErrorAction'
        );
    }

}