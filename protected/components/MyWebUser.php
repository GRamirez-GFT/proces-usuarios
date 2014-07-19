<?php

/**
 *
 * @property integer $id
 * @property string $name
 * @property string $username
 * @property string $role
 * @property integer $company_id
 * @property string $company
 * @property string $subdomain
 * @property array $permissions
 */
class MyWebUser extends CWebUser {

    public function start($username, $password) {
        $usuario = User::model()->findByAttributes(array(
            'username' => $username
        ));
        if (CPasswordHelper::verifyPassword($password, $usuario->password)) {
            Yii::app()->session->regenerateID();
            Yii::app()->user->setState('id', $usuario->id);
            Yii::app()->user->setState('name', $usuario->name);
            Yii::app()->user->setState('username', $usuario->username);
            // Yii::app()->user->setState('role', $usuario->role->name);
            if ($usuario->roles && ($compania = $usuario->roles[0]->company)) {
                Yii::app()->user->setState('company_id', $compania->id);
                Yii::app()->user->setState('company', $compania->name);
                Yii::app()->user->setState('subdomain', $compania->subdomain);
                Yii::app()->user->setState('permissions', $this->getPermissions());
                return true;
            }
        }
        return false;
    }

    public function afterLogin() {
        $sesion = new UserSession();
        $sesion->ipv4 = Yii::app()->request->getUserHostAddress();
        $sesion->session = md5($this->getStateKeyPrefix() . date('YmdHis'));
        $sesion->user_id = $this->id;
        if ($sesion->save()) {
            setcookie('COMPANY', $this->subdomain, time() + 3600, '/');
            setcookie('PROCESID', $sesion->session, time() + 3600, '/');
        }
    }

    public function beforeLogout() {
        Yii::app()->db->createCommand()->update('user_session',
            array(
                'time_logout' => date('Y-m-d H:i:s')
            ), 'session=:t0 AND ipv4=:t1',
            array(
                ':t0' => isset($_COOKIE['PROCESID']) ? $_COOKIE['PROCESID'] : null,
                ':t1' => Yii::app()->request->getUserHostAddress()
            ));
        Yii::app()->request->cookies->clear();
        return true;
    }

    public function getPermissions() {
        $permissions = array();
        /*
         * foreach (Yii::app()->db->createCommand() ->select('m.name AS module, c.name AS controller, a.name AS action')
         * ->from('controller c') ->join('action a', 'a.controller_id=c.id') ->join('role_action r', 'r.action_id=a.id
         * AND r.role_id=:t0', array( ':t0' => $role )) ->join('module m', 'm.id=c.module_id') ->queryAll() as $data) {
         * if (! isset($permissions[$data['module']][$data['controller']])) { if (!
         * isset($permissions[$data['module']])) { $permissions[$data['module']] = array(); }
         * $permissions[$data['module']][$data['controller']] = array(); }
         * $permissions[$data['module']][$data['controller']][] = $data['action']; }
         */
        return $permissions;
    }

}
