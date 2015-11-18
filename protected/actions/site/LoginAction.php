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
            
            $url = WS_SERVER.'/login';
            $headers = array(
                "Accept: application/json", 
                "X-REST-USERNAME: " . $model->username, 
                "X-REST-PASSWORD: " . $model->password, 
                "X-REST-TOKEN: " . Yii::app()->params->token, 
            );
            $postData = '{"company": "'.$model->company.'"}';
            
            $loginCurl = curl_init();
            curl_setopt($loginCurl, CURLOPT_URL, $url);
            curl_setopt($loginCurl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($loginCurl, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($loginCurl, CURLOPT_POST, TRUE);
            curl_setopt($loginCurl, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($loginCurl, CURLOPT_HTTPHEADER, $headers); 
            $loginResponse = curl_exec($loginCurl);
            
            $loginResponse = json_decode($loginResponse);
                
            curl_close($loginCurl);
            
            if ($loginResponse->success && Yii::app()->user->login(new CUserIdentity($model->username, $model->password))) {
                
                $loginResponse->data = json_decode(json_encode($loginResponse->data), true);
                
                foreach ($loginResponse->data as $key => $value) {
                    echo $key.'='.$value.'</br>';
                    Yii::app()->user->setState($key, $value);
                }
                
                setcookie('PROCESID', $loginResponse->data['session_id'], time() + 36000, '/');
                $this->controller->redirect(Yii::app()->user->returnUrl);
                
            } else {
                
                $loginResponse->errors = json_decode(json_encode($loginResponse->errors), true);
                
                if(!empty($loginResponse->errors['product'])) {
                    $model->addError('username', $loginResponse->errors['product']);
                }
                
                if(!empty($loginResponse->errors['company'])) {
                    $model->addError('company', $loginResponse->errors['company']);
                }
                
                if(!empty($loginResponse->errors['user'])) {
                    $model->addError('username', $loginResponse->errors['user']);
                }
                
                if(!empty($loginResponse->errors['password'])) {
                    $model->addError('password', $loginResponse->errors['password']);
                }
            }
        }
        $this->controller->render('login', array(
            'model' => $model
        ));
    }

}