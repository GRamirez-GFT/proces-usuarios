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
                $request['id'] = $user->id;
                $request['name'] = $user->name;
                $request['username'] = $user->username;
                $request['company_id'] = $user->company_id;
                $request['company'] = $user->company_id ? $user->company->name : null;
                $request['subdomain'] = $user->company_id ? $user->company->subdomain : null;
                // TODO: CARGAR PERMISOS DEL PRODUCTO
                $request['permissions'] = '';
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
            $request['id'] = $user->id;
            $request['name'] = $user->name;
            $request['username'] = $user->username;
            $request['company_id'] = $user->company_id;
            $request['company'] = $user->company_id ? $user->company->name : null;
            $request['subdomain'] = $user->company_id ? $user->company->subdomain : null;
            // TODO: CARGAR PERMISOS DEL PRODUCTO
            $request['permissions'] = '';
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
    /*
     * public function getPermissions() { $permissions = array(); foreach (Yii::app()->db->createCommand()
     * ->select('m.name AS module, c.name AS controller, a.name AS action') ->from('controller c') ->join('action a',
     * 'a.controller_id=c.id') ->join('role_action r', 'r.action_id=a.id AND r.role_id=:t0', array( ':t0' => $role ))
     * ->join('module m', 'm.id=c.module_id') ->queryAll() as $data) { if (!
     * isset($permissions[$data['module']][$data['controller']])) { if (! isset($permissions[$data['module']])) {
     * $permissions[$data['module']] = array(); } $permissions[$data['module']][$data['controller']] = array(); }
     * $permissions[$data['module']][$data['controller']][] = $data['action']; } return $permissions; }
     */
}