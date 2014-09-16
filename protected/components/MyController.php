<?php
require_once dirname(__FILE__) . '/helpers.php';

class MyController extends CController {
    public $layout = '//layouts/column2';
    public $defaultAction = 'admin';
    public $menu = array();
    public $breadcrumbs = array();
    public $assets;

    public function init() {
        $this->checkSession();
        $this->assets = ! YII_DEBUG ? Yii::app()->assetManager->publish(Yii::app()->theme->basePath) : Yii::app()->theme->baseUrl;
    }

    public function checkSession() {
        $client = new SoapClient(WS_SERVER);
        if (isset($_COOKIE['PROCESID'])) {
            if ($user_id = $client->validateSession($_COOKIE['PROCESID'], $_SERVER["REMOTE_ADDR"])) {
                if (Yii::app()->user->isGuest || Yii::app()->user->id != $user_id) {
                    Yii::app()->user->login(new CUserIdentity('', ''));
                    $request = json_decode($client->startSession($user_id), true);
                    foreach ($request as $key => $value) {
                        Yii::app()->user->setState($key, $value);
                    }
                    $this->redirect(Yii::app()->user->returnUrl);
                }
            } else {
                $this->redirect(Yii::app()->createAbsoluteUrl('site/logout'));
            }
        }
        if (Yii::app()->user->isGuest && ! preg_match('/\/login$/', Yii::app()->request->getRequestUri())) {
            $this->redirect(Yii::app()->createAbsoluteUrl('site/login'));
        }
    }

    public function filters() {
        return array(
            'accessControl'
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