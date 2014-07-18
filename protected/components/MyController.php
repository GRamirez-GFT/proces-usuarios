<?php

class MyController extends CController {
    public $layout = '//layouts/content';
    public $menu = array();
    public $breadcrumbs = array();
    public $assets;

    public function init() {
        //$this->rewriteUrl();
        $this->assets = YII_DEBUG ? Yii::app()->theme->baseUrl : Yii::app()->assetManager->publish(
            Yii::app()->theme->basePath);
    }

    public function rewriteUrl() {
        if (Yii::app()->user->isGuest) return;
        if (! preg_match('/' . Yii::app()->user->subdomain . '/', Yii::app()->request->getServerName())) {
            $this->redirect('http://' . Yii::app()->user->subdomain . '.proces');
        }
    }

}