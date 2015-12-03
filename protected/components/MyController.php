<?php
require_once dirname(__FILE__) . '/helpers.php';

class MyController extends CController {
    public $layout = '//layouts/content';
    public $defaultAction = 'admin';
    public $menu = array();
    public $breadcrumbs = array();
    public $assets;

    public function init() {
        $this->assets = ! YII_DEBUG ? Yii::app()->assetManager->publish(Yii::app()->theme->basePath) : Yii::app()->theme->baseUrl;
    }

    public function filters() {
        return array(
            'accessControl',
            array('application.filters.GlobalAccessControlFilter'),
            'postOnly + delete'
        );
    }

    public function accessRules() {
        return array(
            array(
                'deny',
                'users' => array(
                    '*'
                )
            )
        );
    }

}