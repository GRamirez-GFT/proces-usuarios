<?php

class LogoutAction extends CAction {

    public function run() {
        
        if(Yii::app()->user->isGuest) {
            Yii::app()->controller->redirect(array(
                'site/login',
            ));
        }
        
        $logoutCurlSuccess = true;
        
        if (isset($_COOKIE['PROCESID'])) {
            
            $url = WS_SERVER.'/logout';
            $postData = '{"session_id": "'.$_COOKIE['PROCESID'].'"}';
            $headers = array(
                "Accept: application/json", 
                "X-REST-USERNAME: default", 
                "X-REST-PASSWORD: default", 
                "X-REST-TOKEN: " . Yii::app()->params->token, 
            );
            
            $logoutCurl = curl_init();
            curl_setopt($logoutCurl, CURLOPT_URL, $url);
            curl_setopt($logoutCurl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($logoutCurl, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($logoutCurl, CURLOPT_POST, TRUE);
            curl_setopt($logoutCurl, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($logoutCurl, CURLOPT_HTTPHEADER, $headers); 
            $logoutResponse = curl_exec($logoutCurl);
            
            if($logoutResponse !== false) {
                $logoutResponse = json_decode($logoutResponse);
                $logoutSuccess = property_exists($logoutResponse, 'success') ? $logoutResponse->success : false;
            }
            
            unset($_COOKIE['PROCESID']);
            setcookie('PROCESID', null, -1, '/');
            
            curl_close($logoutCurl);
        }
        
        Yii::app()->user->logout();
        Yii::app()->controller->redirect(Yii::app()->homeUrl);
    }

}