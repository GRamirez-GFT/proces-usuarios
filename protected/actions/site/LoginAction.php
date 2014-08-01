<?php

class LoginAction extends CAction {

    public function run() {
        $model = new LoginForm();
        if (Yii::app()->request->getPost('LoginForm')) {
            $model->setAttributes(Yii::app()->request->getPost('LoginForm'));
            $client = new SoapClient('http://localhost/proces-usuarios/ws/access');
            $request = json_decode($client->login($model->username, $model->password, $model->company), true);
            if ($request && Yii::app()->user->login(new CUserIdentity($model->username, $model->password))) {
                foreach ($request as $key => $value) {
                    Yii::app()->user->setState($key, $value);
                }
                if ($session = $client->registerSession(Yii::app()->user->getStateKeyPrefix(), $_SERVER["REMOTE_ADDR"],
                    Yii::app()->user->id)) {
                    setcookie('PROCESID', $session, time() + 3600, '/');
                    $this->controller->redirect(Yii::app()->user->returnUrl);
                } else {
                    Yii::app()->user->logout();
                }
            }
        }
        $this->controller->render('login', array(
            'model' => $model
        ));
    }

}