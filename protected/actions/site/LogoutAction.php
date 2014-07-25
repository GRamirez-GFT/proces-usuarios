<?php

class LogoutAction extends CAction {

    public function run() {
        if (isset($_COOKIE['PROCESID'])) {
            $client = new SoapClient('http://localhost/proces-usuarios/ws/access');
            $client->destroySession($_COOKIE['PROCESID'], $_SERVER["REMOTE_ADDR"]);
            setcookie('PROCESID', null, time() - 3600, '/');
        }
        Yii::app()->user->logout();
        Yii::app()->controller->redirect(Yii::app()->homeUrl);
    }

}