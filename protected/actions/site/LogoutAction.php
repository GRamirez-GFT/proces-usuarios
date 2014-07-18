<?php
class LogoutAction extends CAction{

    public function run(){
        Yii::app()->user->logout();
        Yii::app()->controller->redirect(Yii::app()->homeUrl);
    }
}