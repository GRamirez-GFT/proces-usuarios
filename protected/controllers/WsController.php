<?php

class WsController extends CController {
    
    public function accessRules() {
        return array(
            array(
                'allow',
                'actions' => array('REST.GET', 'REST.PUT', 'REST.POST', 'REST.DELETE', 'REST.OPTIONS'),
                'users' => array('*'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    public function actions() {
        return array(
            'REST.' => 'RestfullYii.actions.ERestActionProvider',
        );
    }

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            array(
                'RestfullYii.filters.ERestFilter + REST.GET, REST.PUT, REST.POST, REST.DELETE, REST.OPTIONS'
            ),
        );
    }
//    
//    /**
//     *
//     * @param array $userInfo
//     * @param string $token
//     * @return string @soap
//     */
//    public function login($userInfo, $token) {
//        
//        $request = array(
//            'success' => false,
//            'response' => array(),
//            'errors' => array(
//                'company' => 'No existe la compañia ingresada',
//                'user' => 'El usuario ingresado es inválido',
//                'product' => '',
//                'password' => '',
//            ),
//        );
//        
//        $user = false;
//        
//        if ($userInfo['company']) {
//            
//            $validProduct = false;
//            
//            if($company = Company::model()->findByAttributes(array(
//                'subdomain' => $userInfo['company']
//            ))) {
//                
//                $request['errors']['company'] = null;
//                
//                if($user = User::model()->findByAttributes(array(
//                    'username' => $userInfo['username'], 
//                    'company_id' => $company->id
//                ))) {
//                    
//                    $request['errors']['user'] = null;
//                }
//            } else {
//                $request['errors']['user'] = null;
//            }
//
//        } else {
//            
//            $request['errors']['company'] = null;
//            
//            $user = User::model()->findByAttributes(array(
//                "id" => 1,
//                'username' => $userInfo['username'], 
//                'active' => 1
//            ));
//            
//            // Basically on this case means that input username is not admin
//            if(!$user) {
//                $request['errors']['company'] = 'Ingrese una compañia';
//                $request['errors']['user'] = null;
//            }
//            
//        }
//        
//        if ($user) {
//            
//            $request['errors']['user'] = null;
//            
//            if($user->id != 1) {
//                $validToken = Product::model()->findByAttributes(array('token' => $token));
//
//                if($validToken) {
//
//                    if(ProductUser::model()->findByAttributes(array(
//                        'product_id' => $validToken->id,
//                        'user_id' => $user->id,
//                    ))) {
//
//                        $validProduct = true;
//                        $request['errors']['product'] = null;
//
//                    }
//
//                }
//            } else {
//                $validProduct = true;
//                $request['errors']['product'] = null;   
//            }
//
//            if($validProduct || $token == Yii::app()->params->token) {
//
//                if (CPasswordHelper::verifyPassword($userInfo['password'], $user->password)) {
//
//                    $request['success'] = true;
//                    $request['response'] = self::getUserData($user);
//
//                } else {
//                    $request['errors']['password'] = 'El password ingresado es incorrecto';
//                }
//            } else {
//
//                $request['errors']['product'] = 'El usuario no tiene acceso al producto';
//            }
//        }
//        return json_encode($request);
//    }
//
//    /**
//     *
//     * @param integer $user_id
//     * @return string @soap
//     */
//    public function startSession($user_id) {
//        $request = array();
//        if ($user = User::model()->findByAttributes(
//            array(
//                "id" => $user_id,
//                "active" => 1
//            ))) {
//            $request = self::getUserData($user);
//        }
//        return json_encode($request);
//    }
//
//    /**
//     *
//     * @param string $sesion
//     * @param string $ipv4
//     * @param integer $user_id
//     * @return string @soap
//     */
//    public function registerSession($sesion, $ipv4, $user_id) {
//        $user = new UserSession();
//        $user->session = md5($sesion . date("YmdHis"));
//        $user->ipv4 = $ipv4;
//        $user->user_id = $user_id;
//        return $user->save() ? $user->session : null;
//    }
//
//    /**
//     *
//     * @param string $session
//     * @param string $ipv4
//     * @return integer @soap
//     */
//    public function validateSession($session, $ipv4) {
//        return Yii::app()->db->createCommand()
//            ->select("user_id")
//            ->from("user_session")
//            ->where("session='{$session}' AND ipv4='{$ipv4}' AND time_logout IS NULL")
//            ->limit("1")
//            ->queryScalar();
//    }
//
//    /**
//     *
//     * @param string $session
//     * @param string $ipv4
//     * @return boolean @soap
//     */
//    public function destroySession($session, $ipv4) {
//        return Yii::app()->db->createCommand()->update("user_session",
//            array(
//                "time_logout" => date("Y-m-d H:i:s")
//            ), "session=:t0 AND ipv4=:t1",
//            array(
//                ":t0" => $session,
//                ":t1" => $ipv4
//            ));
//    }
//
//    /**
//     *
//     * @param integer $company_id
//     * @param string $token
//     * @return string @soap
//     */
//    public function getUserCompany($company_id, $token) {
//
//        $product = ProductCompany::model()->with('product')->findByAttributes(
//            array('company_id'=> $company_id), array('condition' => "product.token = '{$token}'")
//        );
//        
//        if(!$product) return false;
//        
//        $request = Yii::app()->db->createCommand()
//            ->select("user.id, user.name, user.username, user.email, user.company_id, user.active, user.date_create")
//            ->from("user")
//            ->join("product_user", "`product_user`.`user_id` = `user`.`id`")
//            ->leftJoin("company", "`company`.`user_id` = `user`.`id`")
//            ->leftJoin("product", "`product_user`.`product_id` = `product`.`id`")
//            ->where("`user`.`company_id`={$company_id} AND `company`.`id` IS NULL  AND `product`.`token` = '".$token."'")
//            ->order("user.username ASC")
//            ->queryAll();
//        return json_encode($request);
//    }
//    
//    /**
//     *
//     * @param integer $company_id
//     * @param string $token
//     * @param integer $user_id
//     * @param string $name
//     * @return string @soap
//     */
//    public function getUser($company_id, $token, $user_id = null, $name = null) {
//
//        $product = ProductCompany::model()->with('product')->findByAttributes(
//            array('company_id'=> $company_id), array('condition' => "product.token = '{$token}'")
//        );
//        
//        if(!$product) return false;
//        
//        $userQuery = "";
//        $userQuery = (!is_null($name)) ? "AND (LOWER(`user`.`name`) LIKE LOWER('%{$name}%'))" : $userQuery;
//        $userQuery = (!is_null($user_id)) ? "AND `user`.`id` = '{$user_id}'" : $userQuery;
//        
//        $request = Yii::app()->db->createCommand()
//            ->select("user.id, user.name, user.username, user.email, user.company_id, user.active, user.date_create")
//            ->from("user")
//            ->join("product_user", "`product_user`.`user_id` = `user`.`id`")
//            ->leftJoin("company", "`company`.`user_id` = `user`.`id`")
//            ->leftJoin("product", "`product_user`.`product_id` = `product`.`id`")
//            ->where("`user`.`company_id`={$company_id} ".$userQuery." AND `product`.`token` = '".$token."'")
//            ->order("user.username ASC")
//            ->queryRow();
//        return json_encode($request);
//    }
//    

//
//    /**
//     *
//     * @param integer $user_id
//     * @param string $token
//     * @return boolean @soap
//     */
//    public function validateProduct($user_id, $token) {
//        $request = null;
//        if ($user_id > 1) {
//            $request = Yii::app()->db->createCommand()
//                ->select("user_id")
//                ->from("product_user")
//                ->join("product p", "p.id=product_id AND p.token='{$token}'")
//                ->where("user_id={$user_id}")
//                ->limit("1")
//                ->queryScalar();
//        } else {
//            if($token == Yii::app()->params->token) {
//                return true;   
//            }
//        }
//        return $request;
//    }
//
//   /**
//     *
//     * @param integer $user_id
//     * @param string $token
//     * @return boolean @soap
//    */
//    public function registerProductUser($user_id, $token) {
//        
//        $product = Product::model()->findByAttributes(array('token'=> $token));
//        
//        if(!$product) return false;
//        
//        $productUser = ProductUser::model()->findByAttributes(array('user_id'=>$user_id, 'product_id' => $product->id));
//        
//        if($productUser) {
//
//            $productUser->is_used = '1';
//        
//            return $productUser->update() ? true : false;
//        } else {
//            return true;
//        }
//        
//    }
//
//   /**
//     *
//     * @param integer $user_id
//     * @param string $token
//     * @return boolean @soap
//    */
//    public function unregisterProductUser($user_id, $token) {
//        
//        $product = Product::model()->findByAttributes(array('token'=> $token));
//        
//        if(!$product) return false;
//        
//        $productUser = ProductUser::model()->findByAttributes(array('user_id'=>$user_id, 'product_id' => $product->id));
//        
//        if($productUser) {
//            $productUser->is_used = false;
//
//            return $productUser->update() ? true : false;
//        } else {
//            return true;
//        }
//        
//    }
    
    public static function validateAccess($username, $password, $token, $company, $checkPassword = true) {
                
        $result = array(
            'success' => false,
            'user' => array(),
            'errors' => array(
                'company' => '',
                'user' => '',
                'product' => '',
                'password' => '',
            ),
        );

        $user = false;

        if (!empty($company)) {

            $validProduct = false;

            if($company = Company::model()->findByAttributes(array(
                'subdomain' => $company
            ))) {

                $result['errors']['company'] = null;

                if($user = User::model()->findByAttributes(array(
                    'username' => $username, 
                    'company_id' => $company->id
                ))) {

                    $result['errors']['user'] = null;
                }
            } else {
                $result['errors']['user'] = null;
                $result['errors']['company'] = 'No existe la compañia ingresada';
            }

        } else {

            $result['errors']['company'] = null;

            $user = User::model()->findByAttributes(array(
                "id" => 1,
                'username' => $username, 
                'active' => 1
            ));

            // Basically on this case means that input username is not admin
            if(!$user) {
                $result['errors']['company'] = 'Ingrese una compañia';
                $result['errors']['user'] = null;
            }

        }

        if ($user) {

            $result['errors']['user'] = null;

            if($user->id != 1) {
                $validToken = Product::model()->findByAttributes(array('token' => $token));

                if($validToken) {

                    if(ProductUser::model()->findByAttributes(array(
                        'product_id' => $validToken->id,
                        'user_id' => $user->id,
                    ))) {

                        $validProduct = true;
                        $result['errors']['product'] = null;
                    }
                }
                
            } else {
                $validProduct = true;
                $result['errors']['product'] = null;   
            }

            if($validProduct || $token == Yii::app()->params->token) {

                if (CPasswordHelper::verifyPassword($password, $user->password) || !$checkPassword) {

                    $result['success'] = true;
                    $result['user'] = self::getUserData($user);

                } else {
                    $result['errors']['password'] = 'El password ingresado es incorrecto';
                }
            } else {

                $result['errors']['product'] = 'El usuario no tiene acceso al producto';
            }
        } else {
            $result['errors']['usuario'] = 'El usuario ingresado es inválido';  
        }
        
        return $result;
    }
    
    public static function getUserData($user, $product = null) {
        $request = array();
        $request["id"] = $user->id;
        $request["name"] = $user->name;
        $request["username"] = $user->username;
        
        if ($request["company_id"] = $user->company_id) {
            
            $urlLogo = (!empty($user->company->url_logo)) ? "http://" . $_SERVER['HTTP_HOST'] . Yii::app()->baseUrl.DIRECTORY_SEPARATOR.$user->company->url_logo : null;
            
            $request["company"] = $user->company->name;
            $request["subdomain"] = $user->company->subdomain;
            $request["url_logo"] = $urlLogo;
            $request["role"] = $user->id == $user->company->user_id ? "company" : "general";
        } else {
            $request["company"] = null;
            $request["subdomain"] = null;
            $request["url_logo"] = null;
            $request["role"] = $user->id == 1 ? "global" : "general";
        }
        return $request;
    }
    
    public function restEvents() {
        
        /*
         * Valida cualquier petición 
         * 
         */
        
        $this->onRest('req.auth.user', function($application_id, $username, $password) {

            if(!isset($_SERVER['HTTP_X_'.$application_id.'_TOKEN'])) {
                return false;
            } else {
                 /*Valida si es un token válido */
                if(!Product::model()->exists("t.token = :token", array(':token' => $_SERVER['HTTP_X_'.$application_id.'_TOKEN']))) {
                    return false;
                }
            }

            if(isset($_GET['session_id'])) {

                /* Valida si es un id de sesión válido */
                $userValidation = self::validateAccess($username, $password, $token, $company, false);
                
                if($userValidation['success']) {
                    
                }
                
                return true;

            } else if(strpos($_SERVER['REQUEST_URI'],'/api/ws/login') !== false) {

                /* Permite ingresar unicamente si se quiere loguear el usuario */
                return true;

            } else {
                return false;
            }
                
        });
        
        /*
         * website-url/api/ws/login
         * 
         *  Ejemplo de headers:
         *  X-REST-USERNAME : admin
         *  X-REST-PASSWORD : 12345
         *  X-REST-TOKEN : EHTJ223SFJ34
         *
         *  Ejemplo de parametros POST:
         *  company: iconomx
         *
         * El resultado:
         * {
         *  "success": true OR false si no pasó alguna validación,
         *  "response": {
         *      "id": user id,
         *      "name": user name,
         *      "username": user alias,
         *      "company_id": company id,
         *      "company": company name,
         *      "subdomain": company subdomain,
         *      "url_logo": url string OR null,
         *      "role": global OR company OR general,
         *  },
         *  "errors": {
         *      "company": null OR error description,
         *      "user": null OR error description,
         *      "product": null OR error description,
         *      "password": null OR error description,
         *  }
         * }
         *
         */
        
        $this->onRest('req.post.login.render', function($data) {
            
            try {
                
                $username = isset($_SERVER['HTTP_X_REST_USERNAME']) ? $_SERVER['HTTP_X_REST_USERNAME'] : '';
                $password = isset($_SERVER['HTTP_X_REST_PASSWORD']) ? $_SERVER['HTTP_X_REST_PASSWORD'] : '';
                $token = isset($_SERVER['HTTP_X_REST_TOKEN']) ? $_SERVER['HTTP_X_REST_TOKEN'] : '';
                $company = isset($data['company']) ? $data['company'] : '';

                $response = self::validateAccess($username, $password, $token, $company);

                if($response['success']) {
                    $userSession = new UserSession();
                    $userSession->session = md5(uniqid() . date("YmdHis"));
                    $userSession->ipv4 = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
                    $userSession->user_id = $response['user']['id'];

                    $userSession->save();

                    $response['user']['session_id'] = $userSession->session; 
                }
                
                return CJSON::encode($response);
                
            } catch (Exception $e) {
                throw new CHttpException(420, 'Error: ' . $e->getMessage());
            }
             
        });
        
       
        /*
         * website-url/api/ws/login
         * 
         *  Ejemplo de headers:
         *  X-REST-USERNAME : admin
         *  X-REST-PASSWORD : 12345
         *  X-REST-TOKEN : EHTJ223SFJ34
         *
         *  Ejemplo de parametros POST:
         *  company: iconomx
         *
         * El resultado:
         * {
         *  "success": true OR false si no pasó alguna validación,
         *  "errors": descripcion de error,
         * }
         *
         */
        
        $this->onRest('req.post.logout.render', function($data) {
            
            try {
                
                $username = isset($_SERVER['HTTP_X_REST_USERNAME']) ? $_SERVER['HTTP_X_REST_USERNAME'] : '';
                $password = isset($_SERVER['HTTP_X_REST_PASSWORD']) ? $_SERVER['HTTP_X_REST_PASSWORD'] : '';
                $token = isset($_SERVER['HTTP_X_REST_TOKEN']) ? $_SERVER['HTTP_X_REST_TOKEN'] : '';
                $company = isset($data['company']) ? $data['company'] : '';

                $response = self::validateAccess($username, $password, $token, $company);
                
                if($response['success']) {
                    echo "ADSA";
                }
                
                return CJSON::encode($response);
                
            } catch (Exception $e) {
                throw new CHttpException(420, 'Error: ' . $e->getMessage());
            }
             
        });
        
    }


}