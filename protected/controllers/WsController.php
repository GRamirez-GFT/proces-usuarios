<?php

class WsController extends CController {

    public function actions() {
        return array(
            'access' => array(
                'class' => 'CWebServiceAction'
            )
        );
    }

    /**
     *
     * @param string $username
     * @param string $password
     * @return string @soap
     */
    public function login($username, $password) {
        $request = array();
        // TODO: CONDICION DE COMPANIA / SUBDOMINIO
        if ($user = User::model()->findByAttributes(
            array(
                'username' => $username,
                'active' => 1
            ))) {
            if (CPasswordHelper::verifyPassword($password, $user->password)) {
                $request = self::getVars($user);
            }
        }
        return json_encode($request);
    }

    /**
     *
     * @param integer $user_id
     * @return string @soap
     */
    public function startSession($user_id) {
        $request = array();
        if ($user = User::model()->findByAttributes(
            array(
                'id' => $user_id,
                'active' => '1'
            ))) {
            $request = self::getVars($user);
        }
        return json_encode($request);
    }

    /**
     *
     * @param string $sesion
     * @param string $ipv4
     * @param integer $user_id
     * @return string @soap
     */
    public function registerSession($sesion, $ipv4, $user_id) {
        $user = new UserSession();
        $user->session = md5($sesion . date('YmdHis'));
        $user->ipv4 = $ipv4;
        $user->user_id = $user_id;
        return $user->save() ? $user->session : null;
    }

    /**
     *
     * @param string $session
     * @param string $ipv4
     * @return boolean @soap
     */
    public function validateSession($session, $ipv4) {
        return Yii::app()->db->createCommand()
            ->select('user_id')
            ->from('user_session')
            ->where("session='{$session}' AND ipv4='{$ipv4}' AND time_logout IS NULL")
            ->queryScalar();
    }

    /**
     *
     * @param string $session
     * @param string $ipv4
     * @return boolean @soap
     */
    public function destroySession($session, $ipv4) {
        return Yii::app()->db->createCommand()->update('user_session',
            array(
                'time_logout' => date('Y-m-d H:i:s')
            ), 'session=:t0 AND ipv4=:t1',
            array(
                ':t0' => $session,
                ':t1' => $ipv4
            ));
    }

    public static function getVars($user, $product = null) {
        $request = array();
        $request['id'] = $user->id;
        $request['name'] = $user->name;
        $request['username'] = $user->username;
        if ($request['company_id'] = $user->company_id) {
            $request['company'] = $user->company->name;
            $request['subdomain'] = $user->company->subdomain;
            $request['role'] = $user->id == $user->company->user_id ? 'company' : 'general';
        } else {
            $request['company'] = '';
            $request['subdomain'] = '';
            $request['role'] = $user->id == 1 ? 'global' : 'general';
        }
        // TODO: CARGAR PERMISOS DEL PRODUCTO
        $request['permissions'] = self::getPermissions($user->id, $product);
        return $request;
    }

    public static function getPermissions($user_id, $product_id) {
        if ($product_id == null) return;
    }

}