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
    
    private static function validateProductAccess($user, $token) {
        
       $userHasProduct = ProductUser::model()->with(array('product'))->exists("product.token = :token AND t.user_id = :user_id",
            array(
            ':token' => $token,
            ':user_id' => $user->id,
        ));

        $companyHasProduct = ProductCompany::model()->with(array('product'))->exists("product.token = :token AND t.company_id = :company_id",
            array(
            ':token' => $token,
            ':company_id' => $user->company_id,
        ));

        $operativeUserValidations = ($companyHasProduct && ($userHasProduct || $token == Yii::app()->params->token));
        $adminValidations = (self::validProductToken($token) && $user->id == 1);

        if($operativeUserValidations || $adminValidations) {
            return true;
        } else {
            return false;
        }
        
    }
    
    private static function validateRestrictedConnection($company, $ipv4) {
        
        if($company->restrict_connection) {
            
            $allowedIp = AllowedIp::model()->findByAttributes(array(
                'company_id' => $company->id,
                'ipv4' => $ipv4
            ));

            $isLocalhost = $_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1';

            if($allowedIp) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
        
    }

    private static function validProductToken($token) {

        $product = Product::model()->findByAttributes(array('token' => $token));

        return $product;

    }
    
    private static function validateSession($sessionId, $token, $ipv4 = null) {
                
        $result = array(
            'success' => false,
            'user' => null,
            'error' => null,
        );
        
        if(empty($sessionId)) {
            $result['error'] = "El ID de sesión no puede estar vacío"; 
        }
        
        $session = UserSession::model()->findByAttributes(array('session' => $sessionId), "time_logout IS NULL");
        
        if($session) {
            
            $hasProductAccess = self::validateProductAccess($session->user, $token);
            
            if(($session->user->id == 1 && $token == Yii::app()->params->token) || $hasProductAccess) {
                $result['success'] = true;
                $result['user'] = self::getUserData($session->user);
            } else {
                $result['success'] = false;
                $result['user'] = array();
                $result['error'] = "No cuenta con acceso a este producto";
            }
            
            if($result['success']) {
                
                if($result['user']['role'] == 'general') {
                    
                    if(!self::validateRestrictedConnection($session->user->company, $ipv4)) {
                        $result['success'] = false;
                        $result['user'] = array();
                        $result['error'] = "El acceso desde la red actual está bloqueado";
                    }

                    if(!$session->user->active) {
                        $result['success'] = false;
                        $result['user'] = array();
                        $result['error'] = "El usuario se encuentra desactivado.";                	
                    }
                }
            }
            
        } else {
            $result['error'] = "El ID de sesión es inválido";
        }
        
        return $result;
        
    }
    
    private static function validateAccess($username, $password, $token, $company, $ipv4 = null) {
                
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
                    'company_id' => $company->id,
                ))) {

                    $result['errors']['user'] = null;
                } else {
                    
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

            if($user->active) {
                
                $result['errors']['user'] = null;

                $hasProductAccess = self::validateProductAccess($user, $token);
                
                if(($user->id == 1 && $token == Yii::app()->params->token) || $hasProductAccess) {

                    $validProduct = true;
                    $result['errors']['product'] = null;

                } else {
                    $validProduct = false;
                    $result['errors']['product'] = "No cuenta con acceso a este producto";
                }

                if($validProduct) {

                    if (CPasswordHelper::verifyPassword($password, $user->password)) {

                        $result['success'] = true;
                        $result['user'] = self::getUserData($user);
                        
                        if($result['user']['role'] == 'general') {
                            
                            if(!self::validateRestrictedConnection($company, $ipv4)) {
                                $result['success'] = false;
                                $result['user'] = array();
                                $result['errors']['user'] = "Acceso restringido en esta red";
                            }
                        }

                    } else {
                        $result['errors']['password'] = 'El password ingresado es incorrecto';
                    }
                }
            } else {
                $result['errors']['user'] = 'El usuario se encuentra desactivado';   
            }
        } else {
            $result['errors']['user'] = 'El usuario ingresado es inválido';  
        }
        
        return $result;
    }
    
    private static function getUserData($user) {
        
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

            $token = isset($_SERVER['HTTP_X_'.$application_id.'_TOKEN']) ? $_SERVER['HTTP_X_'.$application_id.'_TOKEN'] : false;
            
            if(!$token) {
                return false;
            } else {
                 /*Valida si es un token válido */
                if(Product::model()->exists("t.token = :token", array(':token' => $token))) {
                    return true;
                } else {
                    return false;
                }
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
                $ipv4 = isset($data['ipv4']) ? $data['ipv4'] : null;

                $ipv4 = filter_var($ipv4, FILTER_VALIDATE_IP);
                
                $response = self::validateAccess($username, $password, $token, $company, $ipv4);

                if($response['success']) {
                    $userSession = new UserSession();
                    $userSession->session = md5(uniqid() . date("YmdHis"));
                    $userSession->ipv4 = !empty($ipv4) ? $ipv4 : '';
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
         * website-url/api/ws/logout
         * 
         *  Ejemplo de headers:
         *  X-REST-USERNAME : ""
         *  X-REST-PASSWORD : ""
         *  X-REST-TOKEN : CE6202AY6DD28E3B
         *
         *  Ejemplo de parametros POST:
         *  session_id: 6debc49305145b3beeda381ad983fdea
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
                
                $token = isset($_SERVER['HTTP_X_REST_TOKEN']) ? $_SERVER['HTTP_X_REST_TOKEN'] : false;
                $sessionId = isset($data['session_id']) ? $data['session_id'] : null;
                $ipv4 = isset($data['ipv4']) ? $data['ipv4'] : null;
                
                $response= array(
                    'success' => false,
                );
    
                $ipv4 = filter_var($ipv4, FILTER_VALIDATE_IP);
                
                $sessionValidation = self::validateSession($sessionId, $token, $ipv4);
                
                if($sessionValidation['success']) {

                    $session = UserSession::model()->findByAttributes(array('session' => $sessionId));
                    $session->time_logout = date('Y-m-d H:i:s', time());

                    if($session->update()) {
                        $response['success'] = true;
                    }
                }
                
                return CJSON::encode($response);
                
            } catch (Exception $e) {
                throw new CHttpException(420, 'Error: ' . $e->getMessage());
            }
             
        });
        
        /*
         * website-url/api/ws/validateSession
         * 
         *  Ejemplo de headers:
         *  X-REST-USERNAME : ""
         *  X-REST-PASSWORD : ""
         *  X-REST-TOKEN : CE6202AY6DD28E3B
         *
         *  Ejemplo de parametros POST:
         *  session_id: 6debc49305145b3beeda381ad983fdea
         *
         * El resultado:
         * {
         *  "success": true OR false si no pasó alguna validación,
         *  "user": {
         *      "id": user id,
         *      "name": user name,
         *      "username": user alias,
         *      "company_id": company id,
         *      "company": company name,
         *      "subdomain": company subdomain,
         *      "url_logo": url string OR null,
         *      "role": global OR company OR general,
         *  }
         *  "errors": descripcion de error,
         * }
         *
         */
        
        $this->onRest('req.post.validateSession.render', function($data) {
            
            try {
                
                $token = isset($_SERVER['HTTP_X_REST_TOKEN']) ? $_SERVER['HTTP_X_REST_TOKEN'] : false;
                $sessionId = isset($data['session_id']) ? $data['session_id'] : null;
                $ipv4 = isset($data['ipv4']) ? $data['ipv4'] : null;
                
                $response= array(
                    'success' => false,
                    'user' => null,
                    'error' => null,
                );
    
                $ipv4 = filter_var($ipv4, FILTER_VALIDATE_IP);
                
                $sessionValidation = self::validateSession($sessionId, $token, $ipv4);
                
                if($sessionValidation['success']) {
                    $response['user'] = $sessionValidation['user'];
                    $response['success'] = true;
                } else {
                    $response['error'] = $sessionValidation['error'];   
                }
                
                return CJSON::encode($response);
                
            } catch (Exception $e) {
                throw new CHttpException(420, 'Error: ' . $e->getMessage());
            }
             
        });

        /*
         * website-url/api/ws/getCompanies
         * 
         *  Ejemplo de headers:
         *  X-REST-USERNAME : ""
         *  X-REST-PASSWORD : ""
         *  X-REST-TOKEN : CE6202AY6DD28E3B
         *
         *  Ejemplo de parametros POST:
         *
         * El resultado:
         * {
         *  "success": true OR false si no pasó alguna validación,
         *  "companies": [
         *      {
         *      "id": 333,
         *      "name": Proces,
         *      "subdomain": procesmx,
         *      "user_id": 111,
         *      "active": true or false,
         *      "restrict_connection": true or false,
         *      "date_created": 2015-07-01 (Y-m-d),
         *      "url_logo": documents/año/mes/dia/2342f23d3.jpg,
         *      "licenses": 5, (quantity)
         *      "storage": 1, (GB)
         *      },
         *      {
         *  ],
         *  "errors": descripcion de error,
         * }
         *
         */
        
        $this->onRest('req.post.getCompanies.render', function($data) {
            
            try {
                
                $token = isset($_SERVER['HTTP_X_REST_TOKEN']) ? $_SERVER['HTTP_X_REST_TOKEN'] : false;
                
                $response= array(
                    'success' => false,
                    'user' => null,
                    'error' => null,
                );
    
                if($token == Yii::app()->params->token) {
                    
                    $companies = Yii::app()->db->createCommand()
                        ->select("id, name, subdomain, user_id, active, restrict_connection, date_create, url_logo, licenses, storage")
                        ->from("company")
                        ->queryAll();

                    $response['companies'] = $companies;
                    $response['success'] = true;
                    
                } else {
                    $response['error'] = 'El token ingresado es inválido.';
                }             
                
                return CJSON::encode($response);
                
            } catch (Exception $e) {
                throw new CHttpException(420, 'Error: ' . $e->getMessage());
            }
             
        });

        
        /*
         * website-url/api/ws/getCompanyUsers
         * 
         *  Ejemplo de headers:
         *  X-REST-USERNAME : ""
         *  X-REST-PASSWORD : ""
         *  X-REST-TOKEN : CE6202AY6DD28E3B
         *
         *  Ejemplo de parametros POST:
         *  session_id: 6debc49305145b3beeda381ad983fdea
         *
         * El resultado:
         * {
         *  "success": true OR false si no pasó alguna validación,
         *  "users": [
         *      {
         *      "id": 333,
         *      "name": Jorge Gonzalez,
         *      "username": jgonzalez,
         *      "email": jgonzalez@proces.com.mx,
         *      "company_id": 111,
         *      "active": true o false,
         *      "date_created": 2015-07-01 (Y-m-d),
         *      },
         *      {
         *      "id": 333,
         *      "name": Jorge Gonzalez,
         *      "username": jgonzalez,
         *      "email": jgonzalez@proces.com.mx,
         *      "company_id": 111,
         *      "active": true o false,
         *      "date_created": 2015-07-01 (Y-m-d),
         *      },
         *  ],
         *  "errors": descripcion de error,
         * }
         *
         */
        
        $this->onRest('req.post.getCompanyUsers.render', function($data) {
            
            try {
                
                $token = isset($_SERVER['HTTP_X_REST_TOKEN']) ? $_SERVER['HTTP_X_REST_TOKEN'] : false;
                $sessionId = isset($data['session_id']) ? $data['session_id'] : null;
                $ipv4 = isset($data['ipv4']) ? $data['ipv4'] : null;
                $companyId = isset($data['company_id']) ? $data['company_id'] : null;
                
                $response= array(
                    'success' => false,
                    'user' => null,
                    'error' => null,
                );
    
                if($token == Yii::app()->params->token && !empty($companyId) && empty($sessionId) && empty($ipv4)) {
                    
                    $users = Yii::app()->db->createCommand()
                        ->select("user.id, user.name, user.username, user.email, user.company_id, user.active, user.date_create")
                        ->from("user")
                        ->leftJoin("company", "`user`.`company_id` = `company`.`id`")
                        ->where("`user`.`company_id`='".$companyId."' AND `user`.`id` <> `company`.`user_id` ")
                        ->order("user.username ASC")
                        ->queryAll();

                    $response['users'] = $users;
                    $response['success'] = true;
                    
                } else {
                    
                    $ipv4 = filter_var($ipv4, FILTER_VALIDATE_IP);

                    $sessionValidation = self::validateSession($sessionId, $token, $ipv4);

                    if($sessionValidation['success']) {

                        $users = Yii::app()->db->createCommand()
                            ->select("user.id, user.name, user.username, user.email, user.company_id, user.active, user.date_create")
                            ->from("user")
                            ->leftJoin("company", "`user`.`company_id` = `company`.`id`")
                            ->where("`user`.`company_id`='".$sessionValidation['user']['company_id']."' AND `user`.`id` <> `company`.`user_id` ")
                            ->order("user.username ASC")
                            ->queryAll();

                        $response['users'] = $users;
                        $response['success'] = true;
                    } else {
                        $response['error'] = $sessionValidation['error'];   
                    }
                }
                
                
                return CJSON::encode($response);
                
            } catch (Exception $e) {
                throw new CHttpException(420, 'Error: ' . $e->getMessage());
            }
             
        });
        
        /*
         * website-url/api/ws/getUser
         * 
         *  Ejemplo de headers:
         *  X-REST-USERNAME : ""
         *  X-REST-PASSWORD : ""
         *  X-REST-TOKEN : CE6202AY6DD28E3B
         *
         *  Ejemplo de parametros POST:
         *  session_id: 6debc49305145b3beeda381ad983fdea
         *  id: 333 (opcional)
         *  username: jgonzalez (opcional)
         *
         *  Debe enviarse por lo menos uno de los parámetros: ID o username
         *
         * El resultado:
         * {
         *  "success": true OR false si no pasó alguna validación,
         *  "user": [
         *      {
         *      "id": 333,
         *      "name": Jorge Gonzalez,
         *      "username": jgonzalez,
         *      "email": jgonzalez@proces.com.mx,
         *      "company_id": 111,
         *      "active": true o false,
         *      "date_created": 2015-07-01 (Y-m-d),
         *      },
         *  ],
         *  "errors": descripcion de error,
         * }
         *
         */
        
        $this->onRest('req.post.getUser.render', function($data) {
            
            try {
                
                $token = isset($_SERVER['HTTP_X_REST_TOKEN']) ? $_SERVER['HTTP_X_REST_TOKEN'] : false;
                $sessionId = isset($data['session_id']) ? $data['session_id'] : null;
                $username = isset($data['username']) ? $data['username'] : null;
                $userId = isset($data['id']) ? $data['id'] : null;
                $ipv4 = isset($data['ipv4']) ? $data['ipv4'] : null;
                
                $response= array(
                    'success' => false,
                    'user' => null,
                    'error' => null,
                );
    
                $ipv4 = filter_var($ipv4, FILTER_VALIDATE_IP);
                
                $sessionValidation = self::validateSession($sessionId, $token, $ipv4);
                
                if($sessionValidation['success'] && (!empty($username) || !empty($userId))) {
                    
                    if(!empty($userId)) {
                        $userQuery = "`user`.`id` = '{$userId}'" ;
                    } else {
                        $userQuery = "`user`.`username` = '{$username}'";
                    }
                    
                    $user = Yii::app()->db->createCommand()
                        ->select("user.id, user.name, user.username, user.email, user.company_id, user.active, user.date_create")
                        ->from("user")
                        ->leftJoin("company", "`user`.`company_id` = `company`.`id`")
                        ->where("`user`.`company_id`='".$sessionValidation['user']['company_id']."' AND ".$userQuery)
                        ->order("user.username ASC")
                        ->queryRow();
                    
                    if($user) {
                        $response['user'] = $user;
                        $response['success'] = true;
                    } else {
                        $response['error'] = 'No se encontró ningun resultado';
                    }
                } else {
                    
                    if(empty($userId)) {
                        $response['error'] = "Debe especificar un ID o alias";
                    } else if(empty($username)) {
                        $response['error'] = "Debe especificar un ID o alias";
                    } else {
                        $response['error'] = $sessionValidation['error'];   
                    }
                }
                
                return CJSON::encode($response);
                
            } catch (Exception $e) {
                throw new CHttpException(420, 'Error: ' . $e->getMessage());
            }
             
        });
        
        
        /*
         * website-url/api/ws/createUser
         * 
         *  Ejemplo de headers:
         *  X-REST-USERNAME : ""
         *  X-REST-PASSWORD : ""
         *  X-REST-TOKEN : CE6202AY6DD28E3B
         *
         *  Ejemplo de parametros POST:
         *  session_id: 6debc49305145b3beeda381ad983fdea
         *  name: Jorge Gonzalez (opcional)
         *  username: jgonzalez
         *  password: 12345
         *  confirm_password: 12345
         *  email: jgonzalez@proces.com.mx
         *
         *  Debe enviarse por lo menos uno de los parámetros: ID o username
         *
         * El resultado:
         * {
         *  "success": true OR false si no pasó alguna validación,
         *  "user": [
         *      {
         *      "id": 333,
         *      "name": Jorge Gonzalez,
         *      "username": jgonzalez,
         *      "email": jgonzalez@proces.com.mx,
         *      "company_id": 111,
         *      "active": true o false,
         *      "date_created": 2015-07-01 (Y-m-d),
         *      },
         *  ],
         *  "errors": [
         *      errores generales que ocurren por validaciones de los webservices,
         *      errores del modelo al crear el usuario,
         *      errores del modelo al crear la relación que indica que el usuario está usando el producto,
         *  ],
         *  "isNewRecord": true o false dependiendo si se creó el usuario o solo se relacionó con el producto,
         * }
         *
         */
        
        $this->onRest('req.post.createUser.render', function($data) {
            
            try {
                
                $token = isset($_SERVER['HTTP_X_REST_TOKEN']) ? $_SERVER['HTTP_X_REST_TOKEN'] : false;
                $sessionId = isset($data['session_id']) ? $data['session_id'] : null;
                $name = isset($data['name']) ? $data['name'] : null;
                $username = isset($data['username']) ? $data['username'] : null;
                $password = isset($data['password']) ? $data['password'] : null;
                $confirmPasssword = isset($data['confirm_password']) ? $data['confirm_password'] : null;
                $email = isset($data['email']) ? $data['email'] : null;
                $ipv4 = isset($data['ipv4']) ? $data['ipv4'] : null;
                
                $response = array(
                    'success' => false,
                    'user' => null,
                    'errors' => array(),
                );
    
                $ipv4 = filter_var($ipv4, FILTER_VALIDATE_IP);
                
                $sessionValidation = self::validateSession($sessionId, $token, $ipv4);
                
                if($sessionValidation['success']) {
                    
                    if(!empty($username)) {
                        
                        /* Se inicia sesión para no generar conflicto en las partes de los modelos donde se usan datos de sesión */
                        Yii::app()->user->login(new CUserIdentity($sessionValidation['user']['username'], ''));

                        Yii::app()->user->setState('role', $sessionValidation['user']['role']);
                        Yii::app()->user->setState('company_id', $sessionValidation['user']['company_id']);
                        Yii::app()->user->setState('id', $sessionValidation['user']['id']);
        
                        $user = User::model()->findByAttributes(array('username'=> $username, 'company_id' => $sessionValidation['user']['company_id']));
                        $product = Product::model()->findByAttributes(array('token'=> $token));
                        
                        if($user) {
                            
                            $response['isNewRecord'] = false;
                            
                            $productUser = ProductUser::model()->findByAttributes(array('user_id'=> $user->id, 'product_id' => $product->id));

                            if($productUser) {
                                
                                if(!$productUser->is_used) {
                                    
                                    $productUser->is_used = '1';
                                    $productUser->update();

                                    $response['success'] = true;
                                    $response['user'] = Yii::app()->db->createCommand()
                                    ->select("user.id, user.name, user.username, user.email, user.company_id, user.active, user.date_create")
                                    ->from("user")
                                    ->where("`user`.`id`='".$user->id."'")
                                    ->queryRow();
                                } else {
                                    $response['errors']['Error 1'] = "El usuario ingresado ya existe";  
                                }
                                
                            } else {
                                $response['errors']['Error 1'] = "El usuario no tiene asignado el producto donde intenta registrarlo";
                            }
                            
                        } else {
                            
                            $company = Company::model()->findByPk($sessionValidation['user']['company_id']);
                            $activeUsers = User::model()->findAllByAttributes(array(
                                'active' => '1', 
                                'company_id' => $company->id
                            ), "id != {$company->user_id}");

                            if(count($activeUsers) >= $company->licenses) {
                                $response['errors']['Error 1'] = Yii::t('base', 'The company has reached the maximum of active licenses.');
                            } else {
                                $response['isNewRecord'] = true;
                                
                                $model = new UserModel;
                                $model->username = $username;
                                $model->email = $email;
                                $model->name = $name;
                                $model->password = $password;
                                $model->verify_password = $confirmPasssword;
                                $model->list_products = array($product->id);
                                
                                if($model->save()) {
                                    
                                    $productUser = ProductUser::model()->findByAttributes(array('user_id'=> $model->id, 'product_id' => $product->id));
                                    $productUser->is_used = '1';
                                    $productUser->update();
                                    
                                    $response['success'] = true;
                                    $response['user'] = Yii::app()->db->createCommand()
                                    ->select("user.id, user.name, user.username, user.email, user.company_id, user.active, user.date_create")
                                    ->from("user")
                                    ->where("`user`.`id`='".$model->id."'")
                                    ->queryRow();
                                    
                                } else {
                                    foreach($model->getErrors() as $field => $errorsArray) {
                                        $response['errors'][$field] = $errorsArray[0];
                                    }
                                }
                            }
                        }
                        
                    } else {
                        $response['error'] = 'Es necesario especificar un alias';
                    }
                    
                } else {
                    $response['error'] = $sessionValidation['error'];   
                }
                
                return CJSON::encode($response);
                
            } catch (Exception $e) {
                throw new CHttpException(420, 'Error: ' . $e->getMessage());
            }
             
        });
        
        /*
         * website-url/api/ws/updateUser
         * 
         *  Ejemplo de headers:
         *  X-REST-USERNAME : ""
         *  X-REST-PASSWORD : ""
         *  X-REST-TOKEN : CE6202AY6DD28E3B
         *
         *  Ejemplo de parametros POST:
         *  session_id: 6debc49305145b3beeda381ad983fdea
         *  id: 11 (ID de usuario)
         *  name: Jorge Gonzalez (opcional)
         *  password: 12345 (opcional)
         *  confirm_password: 12345 (opcional mientras password esté vacío)
         *  email: jgonzalez@proces.com.mx (opcional)
         *
         * El resultado:
         * {
         *  "success": true OR false si no pasó alguna validación,
         *  "errors": [
         *      errores generales que ocurren por validaciones de los webservices,
         *      errores del modelo al crear el usuario,
         *      errores del modelo al crear la relación que indica que el usuario está usando el producto,
         *  ],
         * }
         *
         */
        
        $this->onRest('req.post.updateUser.render', function($data) {
            
            try {
                
                $token = isset($_SERVER['HTTP_X_REST_TOKEN']) ? $_SERVER['HTTP_X_REST_TOKEN'] : false;
                $sessionId = isset($data['session_id']) ? $data['session_id'] : null;
                $userId = isset($data['id']) ? $data['id'] : null;
                $name = isset($data['name']) ? $data['name'] : null;
                $password = isset($data['password']) ? $data['password'] : null;
                $confirmPasssword = isset($data['confirm_password']) ? $data['confirm_password'] : null;
                $email = isset($data['email']) ? $data['email'] : null;
                $ipv4 = isset($data['ipv4']) ? $data['ipv4'] : null;
                
                $response = array(
                    'success' => false,
                    'user' => null,
                    'errors' => array(),
                );
    
                $ipv4 = filter_var($ipv4, FILTER_VALIDATE_IP);
                
                $sessionValidation = self::validateSession($sessionId, $token, $ipv4);
                
                if($sessionValidation['success']) {
                    
                    /* Se inicia sesión para no generar conflicto en las partes de los modelos donde se usan datos de sesión */
                    Yii::app()->user->login(new CUserIdentity($sessionValidation['user']['username'], ''));

                    Yii::app()->user->setState('role', $sessionValidation['user']['role']);
                    Yii::app()->user->setState('company_id', $sessionValidation['user']['company_id']);
                    Yii::app()->user->setState('id', $sessionValidation['user']['id']);

                    $user = UserModel::model()->findByPk($userId);

                    if($user) {

                        if(!empty($name)) {
                            $user->name = $name;
                        }
                        
                        $user->password = null;
                        
                        if(!empty($password)) {
                            $user->password = $password;
                        }
                        
                        if(!empty($confirmPasssword)) {
                            $user->verify_password = $confirmPasssword;
                        }
                        
                        if(!empty($email)) {
                            $user->email = $email;
                        }
                            
                        if($user->validate(array('name', 'password', 'email', 'verify_password'))) {
                            
                            if(is_null($user->password)) {
                                $user->update(array('name', 'email'));
                            } else {
                                $user->update(array('name', 'password', 'email'));
                            }

                            $response['success'] = true;
                            
                        } else {
                            
                            foreach($user->getErrors() as $field => $errorsArray) {
                                $response['errors'][$field] = $errorsArray[0];
                            }
                        }

                    } else {
                        $response['errors']['Error 1'] = 'El ID de usuario es inválido';
                    }
                    
                } else {
                    $response['errors']['Error 1'] = $sessionValidation['error'];   
                }
                
                return CJSON::encode($response);
                
            } catch (Exception $e) {
                throw new CHttpException(420, 'Error: ' . $e->getMessage());
            }
             
        });

        
        /*
         * website-url/api/ws/activateUser
         * 
         *  Ejemplo de headers:
         *  X-REST-USERNAME : ""
         *  X-REST-PASSWORD : ""
         *  X-REST-TOKEN : CE6202AY6DD28E3B
         *
         *  Ejemplo de parametros POST:
         *  session_id: 6debc49305145b3beeda381ad983fdea
         *  id: 11 (ID de usuario)
         *
         * El resultado:
         * {
         *  "success": true OR false si no pasó alguna validación,
         *  "errors": [
         *      errores generales que ocurren por validaciones de los webservices,
         *      errores del modelo al activar/desactivar el usuario,
         *  ],
         * }
         *
         */
        
        $this->onRest('req.post.activateUser.render', function($data) {
            
            try {
                
                $token = isset($_SERVER['HTTP_X_REST_TOKEN']) ? $_SERVER['HTTP_X_REST_TOKEN'] : false;
                $sessionId = isset($data['session_id']) ? $data['session_id'] : null;
                $userId = isset($data['id']) ? $data['id'] : null;
                $ipv4 = isset($data['ipv4']) ? $data['ipv4'] : null;
                
                $response = array(
                    'success' => false,
                    'user' => null,
                    'errors' => array(),
                );
    
                $ipv4 = filter_var($ipv4, FILTER_VALIDATE_IP);
                
                $sessionValidation = self::validateSession($sessionId, $token, $ipv4);
                
                if($sessionValidation['success']) {
                    
                    /* Se inicia sesión para no generar conflicto en las partes de los modelos donde se usan datos de sesión */
                    Yii::app()->user->login(new CUserIdentity($sessionValidation['user']['username'], ''));

                    Yii::app()->user->setState('role', $sessionValidation['user']['role']);
                    Yii::app()->user->setState('company_id', $sessionValidation['user']['company_id']);
                    Yii::app()->user->setState('id', $sessionValidation['user']['id']);

                    $user = UserModel::model()->findByPk($userId);

                    if($user) {

                        $validUpdate = true;

                        if($user->active) {
                            $user->active = 0;
                        } else {

                            $activeUsers = User::model()->findAllByAttributes(array(
                                'active' => '1', 
                                'company_id' => $user->company_id
                            ), "id != {$user->company->user_id}");

                            if(count($activeUsers) >= $user->company->licenses) {
                                $validUpdate = false;
                                $response['errors']['Error 1'] = Yii::t('base', 'The company has reached the maximum of active licenses.');
                            }

                            $user->active = 1;
                        }
                            
                        if($validUpdate) {
                            $user->update(array('active'));
                            $response['success'] = true;
                        }

                    } else {
                        $response['errors']['Error 1'] = 'El ID de usuario es inválido';
                    }
                    
                } else {
                    $response['errors']['Error 1'] = $sessionValidation['error'];   
                }
                
                return CJSON::encode($response);
                
            } catch (Exception $e) {
                throw new CHttpException(420, 'Error: ' . $e->getMessage());
            }
             
        });
        
        /*
         * website-url/api/ws/deleteUser
         * 
         *  Ejemplo de headers:
         *  X-REST-USERNAME : ""
         *  X-REST-PASSWORD : ""
         *  X-REST-TOKEN : CE6202AY6DD28E3B
         *
         *  Ejemplo de parametros POST:
         *  session_id: 6debc49305145b3beeda381ad983fdea
         *  id: 11 (ID de usuario)
         *
         * El resultado:
         * {
         *  "success": true OR false si no pasó alguna validación,
         *  "errors": descripción del error
         * }
         *
         */
        
        $this->onRest('req.post.deleteUser.render', function($data) {
            
            try {
                
                $token = isset($_SERVER['HTTP_X_REST_TOKEN']) ? $_SERVER['HTTP_X_REST_TOKEN'] : false;
                $sessionId = isset($data['session_id']) ? $data['session_id'] : null;
                $userId = isset($data['id']) ? $data['id'] : null;
                $ipv4 = isset($data['ipv4']) ? $data['ipv4'] : null;
                
                $response = array(
                    'success' => false,
                    'user' => null,
                    'errors' => array(),
                );
    
                $ipv4 = filter_var($ipv4, FILTER_VALIDATE_IP);
                
                $sessionValidation = self::validateSession($sessionId, $token, $ipv4);
                
                if($sessionValidation['success']) {

                    $user = User::model()->findByPk($userId);
                    $product = Product::model()->findByAttributes(array('token'=> $token));

                    if($user) {

                        $userProducts = ProductUser::model()->findAllByAttributes(array('is_used' => '1', 'user_id' => $user->id));
                            
                        try {
                            
                            $transaction = Yii::app()->db->getCurrentTransaction() ? null : Yii::app()->db->beginTransaction();
                            
                            if($userProducts) {

                                if(count($userProducts) > 1) {

                                    ProductUser::model()->deleteAllByAttributes(array('user_id' => $user->id, 'product_id' => $product->id));
                                    
                                    $response['success'] = true;

                                } else if($userProducts[0]->product_id == $product->id) {

                                    ProductUser::model()->deleteAllByAttributes(array('user_id' => $user->id));
                                    UserSession::model()->deleteAllByAttributes(array('user_id' => $user->id));
                                    User::model()->deleteByPk($user->id);
                                    
                                    $response['success'] = true;
                                }

                            } else {
                                
                                ProductUser::model()->deleteAllByAttributes(array('user_id' => $user->id));
                                UserSession::model()->deleteAllByAttributes(array('user_id' => $user->id));
                                User::model()->deleteByPk($user->id);
                                
                                $response['success'] = true;
                            }
                            
                            $transaction ? $transaction->commit() : null;
                            
                        } catch (Exception $e) {
                            $transaction ? $transaction->rollback() : null;
                            
                            $response['error'] = "Lo sentimos, ocurrió un error";
                        }

                    } else {
                        $response['error'] = 'El ID de usuario es inválido'; 
                    }
                    
                } else {
                    $response['error'] = $sessionValidation['error'];   
                }
                
                return CJSON::encode($response);
                
            } catch (Exception $e) {
                throw new CHttpException(420, 'Error: ' . $e->getMessage());
            }
             
        });

        /*
         * website-url/api/ws/registerStorage
         * 
         *  Ejemplo de headers:
         *  X-REST-USERNAME : ""
         *  X-REST-PASSWORD : ""
         *  X-REST-TOKEN : CE6202AY6DD28E3B
         *
         *  Ejemplo de parametros POST:
         *  company_id: 111 (ID de la compañia a la cuál se le registra almacenamiento)
         *  value: (MB del archivo)
         *  action: 'add' OR 'discount' OR 'replace'
         *  product_token: CE6202AY6DD28E3B (token del producto al cual se le está registrando almacenamiento)
         *
         * El resultado:
         * {
         *  "success": true OR false si no pasó alguna validación,
         *  "storage": {
         *     "total": 1024, (Representing MB)
         *     "company_used": 500, (Representing MB)
         *     "product_used": 500, (Representing MB)
         *     },
         *  "errors": [
         *      Error de compañia inválida
         *      Error de producto inválido
         *      Errores al registrar almacenamiento 
         *  ]
         * }
         *
         */
        
        $this->onRest('req.post.registerStorage.render', function($data) {
            
            try {
                
                $token = isset($_SERVER['HTTP_X_REST_TOKEN']) ? $_SERVER['HTTP_X_REST_TOKEN'] : false;
                $productToken = isset($data['product_token']) ? $data['product_token'] : null;
                $value = isset($data['value']) ? $data['value'] : null;
                $action = isset($data['action']) ? $data['action'] : null;
                $companyId = isset($data['company_id']) ? $data['company_id'] : null;
                
                $response= array(
                    'success' => false,
                    'storage' => null,
                    'errors' => array(),
                );

                $validActions = array('add', 'discount', 'replace');

                if($token == Yii::app()->params->token 
                    && !empty($companyId) 
                    && in_array($action, $validActions) 
                    && !empty($productToken)
                    && is_numeric($value)) {
                    
                    $product = Product::model()->findByAttributes(array('token' => $productToken));
                    $company = Company::model()->findByPk($companyId);

                    if($product && $company) {

                        $registeredStorage = UsedStorage::model()->findByAttributes(array(
                            'product_id' => $product->id,
                            'company_id' => $company->id,
                        ));

                        if($registeredStorage) {
                            switch ($action) {
                                case 'add':
                                    $newStorage = $registeredStorage->quantity + $value;
                                    break;
                                case 'discount':
                                    $newStorage = $registeredStorage->quantity - $value;
                                    break;
                                case 'replace':
                                    $newStorage = $value;
                                    break;
                                default:
                                    $newStorage = $registeredStorage->quantity;
                                    break;
                            }

                            $registeredStorage->quantity = $newStorage;
                            $registeredStorage->update(array('quantity'));

                            $response['storage']['product_used'] = $registeredStorage->quantity;
                        } else {
                            $usedStorage = new UsedStorage;
                            $usedStorage->company_id = $company->id;
                            $usedStorage->product_id = $product->id;
                            $usedStorage->quantity = $value;
                            $usedStorage->save();
                            
                            $response['storage']['product_used'] = $usedStorage->quantity;
                        }

                        $companyModel = CompanyModel::model()->findByPk($companyId);

                        $response['storage']['company_used'] = $companyModel->usedStorage;
                        $response['storage']['total'] = $companyModel->storage * (1000*1000);
                        $response['success'] = true;

                    } else {
                        if(!$product) {
                            $response['errors']['Error de producto'] = 'El producto especificado no existe.';
                        }

                        if(!$company) {
                            $response['errors']['Error de compañia'] = 'La compañia especificado no existe.';
                        }
                    }
                    
                } else {

                    if($token != Yii::app()->params->token) {
                        $response['errors']['Error token'] = 'Token inválido.';
                    }

                    $response['errors']['Error 1'] = 'Debe ingresar información válida.';
                }
                
                return CJSON::encode($response);
                
            } catch (Exception $e) {
                throw new CHttpException(420, 'Error: ' . $e->getMessage());
            }
             
        });

        /*
         * website-url/api/ws/getStorage
         * 
         *  Ejemplo de headers:
         *  X-REST-USERNAME : ""
         *  X-REST-PASSWORD : ""
         *  X-REST-TOKEN : CE6202AY6DD28E3B
         *
         *  Ejemplo de parametros POST:
         *  company_id: 111 (ID de la compañia a la cuál se le registra almacenamiento)
         *  product_token: CE6202AY6DD28E3B (token del producto al cual se está solicitando info)
         *
         * El resultado:
         * {
         *  "success": true OR false si no pasó alguna validación,
         *  "storage": {
         *     "total": 1024, (Representing MB)
         *     "company_used": 500, (Representing MB)
         *     "product_used": 500, (Representing MB)
         *     },
         *  "errors": [
         *      Error de compañia inválida
         *      Error de producto inválido
         *  ]
         * }
         *
         */
        
        $this->onRest('req.post.getStorage.render', function($data) {
            
            try {
                
                $token = isset($_SERVER['HTTP_X_REST_TOKEN']) ? $_SERVER['HTTP_X_REST_TOKEN'] : false;
                $productToken = isset($data['product_token']) ? $data['product_token'] : null;
                $companyId = isset($data['company_id']) ? $data['company_id'] : null;
                
                $response= array(
                    'success' => false,
                    'storage' => null,
                    'errors' => array(),
                );

                $validActions = array('add', 'discount', 'replace');

                if($token == Yii::app()->params->token && !empty($companyId) && !empty($productToken)) {
                    
                    $product = Product::model()->findByAttributes(array('token' => $productToken));
                    $company = Company::model()->findByPk($companyId);

                    if($product && $company) {

                        $registeredStorage = UsedStorage::model()->findByAttributes(array(
                            'product_id' => $product->id,
                            'company_id' => $company->id,
                        ));

                        $companyModel = CompanyModel::model()->findByPk($companyId);

                        $response['storage']['product_used'] = $registeredStorage ? $registeredStorage->quantity : 0;
                        $response['storage']['company_used'] = $companyModel->usedStorage;
                        $response['storage']['total'] = $companyModel->storage * (1000*1000);
                        $response['success'] = true;

                    } else {
                        if(!$product) {
                            $response['errors']['Error de producto'] = 'El producto especificado no existe.';
                        }

                        if(!$company) {
                            $response['errors']['Error de compañia'] = 'La compañia especificado no existe.';
                        }
                    }
                    
                } else {

                    if($token != Yii::app()->params->token) {
                        $response['errors']['Error token'] = 'Token inválido.';
                    }

                    $response['errors']['Error 1'] = 'Debe ingresar información válida.';
                }
                
                return CJSON::encode($response);
                
            } catch (Exception $e) {
                throw new CHttpException(420, 'Error: ' . $e->getMessage());
            }
             
        });
        
    }


}