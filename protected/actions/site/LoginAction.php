<?php

class LoginAction extends CAction {

    public function run() {
        
        if(! Yii::app()->user->isGuest) {
            Yii::app()->controller->redirect(Yii::app()->homeUrl);
        }
        
        $this->controller->layout = '//layouts/main';
        $model = new LoginForm();

        if (Yii::app()->request->getPost(get_class($model))) {
            
            $model->setAttributes(Yii::app()->request->getPost(get_class($model)));
            
            $client = new SoapClient(WS_SERVER);
            $params = array(
                'username' => $model->username,
                'password' => $model->password,
                'company' => $model->company,
            );
            $request = json_decode($client->login($params, Yii::app()->params->token), true);
            
            if ($request['status'] && Yii::app()->user->login(new CUserIdentity($model->username, $model->password))) {
                
                foreach ($request['response'] as $key => $value) {
                    Yii::app()->user->setState($key, $value);
                }
                
                if ($session = $client->registerSession(Yii::app()->user->getStateKeyPrefix(), $_SERVER["REMOTE_ADDR"],
                    Yii::app()->user->id)) {
                    setcookie('PROCESID', $session, time() + 36000, '/');
                    $this->controller->redirect(Yii::app()->user->returnUrl);
                } else {
                    Yii::app()->user->logout();
                }
            } else {
                
                if(!empty($request['errors']['product'])) {
                    $model->addError('username', $request['errors']['product']);
                }
                
                if(!empty($request['errors']['company'])) {
                    $model->addError('company', $request['errors']['company']);
                }
                
                if(!empty($request['errors']['user'])) {
                    $model->addError('username', $request['errors']['user']);
                }
                
                if(!empty($request['errors']['password'])) {
                    $model->addError('password', $request['errors']['password']);
                }
            }
        }
        $this->controller->render('login', array(
            'model' => $model
        ));
    }

}