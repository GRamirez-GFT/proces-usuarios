<?php

class LogoutAction extends CAction {

    public function run() {
        
        if(Yii::app()->user->isGuest) {
            Yii::app()->controller->redirect(array(
                'site/login',
            ));
        }
        
        if (isset($_COOKIE['PROCESID']) && !Yii::app()->user->isGuest) {
            
            $url = WS_SERVER.'/logout';
            $headers = array(
                "Accept: application/json", 
                "X-REST-USERNAME: " . Yii::app()-user->username, 
                "X-REST-PASSWORD: " . Yii::app()-user->password, 
                "X-REST-TOKEN: " . Yii::app()->params->token, 
            );
            $postData = '{"company": "'.Yii::app()->user->subdomain.'", "session_id": "'.$_COOKIE['PROCESID'].'"}';
            
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
            
            $client = new SoapClient(WS_SERVER);
            $client->destroySession($_COOKIE['PROCESID'], $_SERVER["REMOTE_ADDR"], Yii::app()->user->id);
            setcookie('PROCESID', null, time() - 36000, '/');
        }
        Yii::app()->user->logout();
        Yii::app()->controller->redirect(Yii::app()->homeUrl);
    }

}