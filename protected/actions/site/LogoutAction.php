<?php

class LogoutAction extends CAction {

    public function run() {
        
        if(Yii::app()->user->isGuest) {
            Yii::app()->controller->redirect(array(
                'site/login',
            ));
        }
        
        if (isset($_COOKIE['PROCESID']) && ! Yii::app()->user->isGuest) {
            $client = new SoapClient(WS_SERVER);
            $client->destroySession($_COOKIE['PROCESID'], $_SERVER["REMOTE_ADDR"], Yii::app()->user->id);
            setcookie('PROCESID', null, time() - 36000, '/');
        }
        Yii::app()->user->logout();
        Yii::app()->controller->redirect(Yii::app()->homeUrl);
    }

}