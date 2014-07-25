<?php

class MyController extends CController {
    public $layout = '//layouts/content';
    public $menu = array();
    public $breadcrumbs = array();
    public $assets;

    public function init() {
        $this->checkSession();
        // $this->rewriteUrl();
        $this->assets = YII_DEBUG ? Yii::app()->theme->baseUrl : Yii::app()->assetManager->publish(
            Yii::app()->theme->basePath);
    }

    public function checkSession() {
        $client = new SoapClient('http://localhost/proces-usuarios/ws/access');
        if (isset($_COOKIE['PROCESID'])) {
            if ($user_id = $client->validateSession($_COOKIE['PROCESID'], $_SERVER["REMOTE_ADDR"])) {
                if (Yii::app()->user->isGuest || Yii::app()->user->id != $user_id) {
                    Yii::app()->user->login(new CUserIdentity('', ''));
                    $request = json_decode($client->stratSession($user_id), true);
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

    public function rewriteUrl() {
        if (Yii::app()->user->isGuest) return;
        if (! preg_match('/' . Yii::app()->user->subdomain . '/', Yii::app()->request->getServerName())) {
            $this->redirect('http://' . Yii::app()->user->subdomain . '.proces');
        }
    }

}