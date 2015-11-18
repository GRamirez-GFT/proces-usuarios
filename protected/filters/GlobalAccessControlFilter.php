<?php

class GlobalAccessControlFilter extends CFilter
{
    protected function preFilter($filterChain)
    {
//        $client = new SoapClient(WS_SERVER);
//        if ($user_id = $client->validateSession(isset($_COOKIE['PROCESID']) ? $_COOKIE['PROCESID'] : 0, $_SERVER["REMOTE_ADDR"])) {
//            if (Yii::app()->user->isGuest || Yii::app()->user->id != $user_id) {
//                Yii::app()->user->login(new CUserIdentity('', ''));
//                $request = json_decode($client->startSession($user_id), true);
//                foreach ($request as $key => $value) {
//                    Yii::app()->user->setState($key, $value);
//                }
//                Yii::app()->request->redirect(Yii::app()->user->returnUrl);
//            }
//        } else {
//            if(!preg_match('/\/logout$/', Yii::app()->request->getRequestUri()) && !preg_match('/\/login$/', Yii::app()->request->getRequestUri())){
//                Yii::app()->request->redirect(Yii::app()->createAbsoluteUrl('site/logout'));
//            }
//        }
//        if (Yii::app()->user->isGuest && ! preg_match('/\/login$/', Yii::app()->request->getRequestUri())) {
//            Yii::app()->request->redirect(Yii::app()->createAbsoluteUrl('site/login'));
//        echo "ASD";
//        }
        return true; // false if the action should not be executed
    }
 
    protected function postFilter($filterChain)
    {
        // logic being applied after the action is executed
    }
}

?>