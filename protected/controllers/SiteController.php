<?php

class SiteController extends MyController {

    public function filters() {
        return array(
            'accessControl'
        );
    }

    public function accessRules() {
        return array(
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
                    'login',
                ),
                'users' => array(
                    '*'
                )
            ),
            array(
                'deny',
                'users' => array(
                    '*'
                )
            )
        );
    }

    public function actions() {
        return array(
            'login' => 'application.actions.site.LoginAction',
            'logout' => 'application.actions.site.LogoutAction',
            'cpanel' => 'application.actions.site.CpanelAction',
            'contact' => 'application.actions.site.ContactAction',
            'error' => 'application.actions.site.ErrorAction'
        );
    }

    public function actionIndex() {
        $this->render('index');
    }

}