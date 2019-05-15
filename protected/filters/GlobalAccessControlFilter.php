<?php

class GlobalAccessControlFilter extends CFilter {
    
    protected function preFilter($filterChain) {
        
        if(isset($_COOKIE['PROCESID'])) {
            
            $url = WS_SERVER.'/validateSession';
            $postData = '{"session_id": "'.$_COOKIE['PROCESID'].'", "ipv4":"'.$_SERVER['REMOTE_ADDR'].'"}';
            $headers = array(
                "Accept: application/json", 
                "X-REST-USERNAME: default", 
                "X-REST-PASSWORD: default", 
                "X-REST-TOKEN: " . Yii::app()->params->token, 
            );
            
            $sessionCurl = curl_init();
            curl_setopt($sessionCurl, CURLOPT_URL, $url);
            curl_setopt($sessionCurl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($sessionCurl, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($sessionCurl, CURLOPT_POST, TRUE);
            curl_setopt($sessionCurl, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($sessionCurl, CURLOPT_HTTPHEADER, $headers); 
            $sessionResponse = curl_exec($sessionCurl);

            if($sessionResponse !== false) {
                
                $sessionResponse = json_decode($sessionResponse);
                $sessionSuccess = property_exists($sessionResponse, 'success') ? $sessionResponse->success : false;
                
                if($sessionSuccess) {
                    
                    $sessionResponse->user = json_decode(json_encode($sessionResponse->user), true);
                    
                    if (Yii::app()->user->isGuest || Yii::app()->user->id != $sessionResponse->user['id']) {
                        
                        Yii::app()->user->login(new CUserIdentity($sessionResponse->user['username'], ''));
                        
                        foreach ($sessionResponse->user as $key => $value) {
                            Yii::app()->user->setState($key, $value);
                        }
                    }

                    setcookie('PROCESID', $_COOKIE['PROCESID'], time() + 36000, '/');
                    
                    return true;
                    
                } else {
                    return self::loginRedirect();
                }
                
            } else {
                return self::loginRedirect();
            }
            
            curl_close($sessionCurl);

        } else {
            return self::loginRedirect();
        }
    }
 
    protected function postFilter($filterChain) {
        // logic being applied after the action is executed
    }
    
    private static function loginRedirect() {

    	/* At this point it could be here cause cookie was deleted from other product but local session is still active OR cause current action is public independent from
    	*  user session. So we need to heck rules to see if action is public and let continue, otherwise user validation came at this point due to
    	*  local session active and cookie deleted so it needs to be refreshed.
    	*/
        $requestedUri = Yii::app()->request->getRequestUri();
        
        if(! preg_match('/\/login$/', $requestedUri) && !preg_match('/\/logout$/', $requestedUri) && !preg_match('/\/logout\?save_cookie\=true$/', $requestedUri) && !Yii::app()->user->isGuest) {

        	if(self::isPublicAllowedAction()) {
        		return true;
        	} else {
            	Yii::app()->request->redirect(Yii::app()->createAbsoluteUrl('site/logout?save_cookie=true'));
        	}
        } else if(! preg_match('/\/login$/', $requestedUri) && !preg_match('/\/logout$/', $requestedUri) && !preg_match('/\/logout\?save_cookie\=true$/', $requestedUri)) {

        	if(self::isPublicAllowedAction()) {
        		return true;
        	} else {
            	Yii::app()->request->redirect(Yii::app()->createAbsoluteUrl('site/logout'));
        	}
        } else {
            return true;
        }
        
    }

    private function isPublicAllowedAction() {

    	if(Yii::app()->controller->action) {

	    	$accessRules = Yii::app()->controller->accessRules();

	    	foreach($accessRules as $ruleName => $ruleConfig) {

	    		$isAllow = $ruleConfig[0] == 'allow';
	    		$isPublicAllowing = isset($ruleConfig['users']) && in_array('*', $ruleConfig['users']);
	    		$appliesToCurrentAction = isset($ruleConfig['actions']) && in_array(Yii::app()->controller->action->id, $ruleConfig['actions']);

	    		if($isAllow && $isPublicAllowing && $appliesToCurrentAction)  {
	    			return true;
	    		}
	    	}
    	}

    	return false;

    }
}

?>