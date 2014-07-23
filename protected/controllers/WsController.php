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
        if (User::model()->exists("username='{$username}' AND active<>0")) {
            // TODO: CONDICION DE COMPANIA / SUBDOMINIO
            if ($usuario = User::model()->findByAttributes(array(
                'username' => $username
            ))) {
                if (CPasswordHelper::verifyPassword($password, $usuario->password)) {
                    $request['id'] = $usuario->id;
                    $request['name'] = $usuario->name;
                    $request['username'] = $usuario->username;
                    $request['company_id'] = $usuario->roles[0]->company->id;
                    $request['company'] = $usuario->roles[0]->company->name;
                    $request['subdomain'] = $usuario->roles[0]->company->subdomain;
                    // TODO: CARGAR PERMISOS DEL PRODUCTO
                    $request['permissions'] = '';
                }
            }
        }
        return json_encode($request);
    }

}