<?php

class WsController extends CController {

    public function actions() {
        return array(
            "access" => array(
                "class" => "CWebServiceAction"
            )
        );
    }

    /**
     *
     * @param array $userInfo
     * @param string $token
     * @return string @soap
     */
    public function login($userInfo, $token) {
        
        $request = array(
            'status' => false,
            'response' => array(),
            'errors' => array(
                'company' => 'No existe la empresa ingresada',
                'user' => 'El usuario ingresado es inválido',
                'product' => '',
                'password' => '',
            ),
        );
        
        $user = false;
        
        if ($userInfo['company']) {
            
            $validProduct = false;
            
            if($company = Company::model()->findByAttributes(array(
                'subdomain' => $userInfo['company']
            ))) {
                
                $request['errors']['company'] = null;
                
                if($user = User::model()->findByAttributes(array(
                    'username' => $userInfo['username'], 
                    'company_id' => $company->id
                ))) {
                    
                    $request['errors']['user'] = null;
                }
            } else {
                $request['errors']['user'] = null;
            }

        } else {
            
            $request['errors']['company'] = null;
            
            $user = User::model()->findByAttributes(array(
                "id" => 1,
                'username' => $userInfo['username'], 
                'active' => 1
            ));
            
            // Basically on this case means that input username is not admin
            if(!$user) {
                $request['errors']['company'] = 'Ingrese una empresa';
                $request['errors']['user'] = null;
            }
            
        }
        
        if ($user) {
            
            $request['errors']['user'] = null;
            
            if($user->id != 1) {
                $validToken = Product::model()->findByAttributes(array('token' => $token));

                if($validToken) {

                    if(ProductUser::model()->findByAttributes(array(
                        'product_id' => $validToken->id,
                        'user_id' => $user->id,
                    ))) {

                        $validProduct = true;
                        $request['errors']['product'] = null;

                    }

                }
            } else {
                $validProduct = true;
                $request['errors']['product'] = null;   
            }

            if($validProduct || $token == Yii::app()->params->token) {

                if (CPasswordHelper::verifyPassword($userInfo['password'], $user->password)) {

                    $request['status'] = true;
                    $request['response'] = self::getVars($user);

                } else {
                    $request['errors']['password'] = 'El password ingresado es incorrecto';
                }
            } else {

                $request['errors']['product'] = 'El usuario no tiene acceso al producto';
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
                "id" => $user_id,
                "active" => 1
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
        $user->session = md5($sesion . date("YmdHis"));
        $user->ipv4 = $ipv4;
        $user->user_id = $user_id;
        return $user->save() ? $user->session : null;
    }

    /**
     *
     * @param string $session
     * @param string $ipv4
     * @return integer @soap
     */
    public function validateSession($session, $ipv4) {
        return Yii::app()->db->createCommand()
            ->select("user_id")
            ->from("user_session")
            ->where("session='{$session}' AND ipv4='{$ipv4}' AND time_logout IS NULL")
            ->limit("1")
            ->queryScalar();
    }

    /**
     *
     * @param string $session
     * @param string $ipv4
     * @return boolean @soap
     */
    public function destroySession($session, $ipv4) {
        return Yii::app()->db->createCommand()->update("user_session",
            array(
                "time_logout" => date("Y-m-d H:i:s")
            ), "session=:t0 AND ipv4=:t1",
            array(
                ":t0" => $session,
                ":t1" => $ipv4
            ));
    }

    /**
     *
     * @param integer $company_id
     * @param string $token
     * @return string @soap
     */
    public function getUserCompany($company_id, $token) {

        $product = ProductCompany::model()->with('product')->findByAttributes(
            array('company_id'=> $company_id), array('condition' => "product.token = '{$token}'")
        );
        
        if(!$product) return false;
        
        $request = Yii::app()->db->createCommand()
            ->select("user.id, user.name, user.username, user.email, user.company_id, user.active, user.date_create")
            ->from("user")
            ->join("product_user", "`product_user`.`user_id` = `user`.`id`")
            ->leftJoin("company", "`company`.`user_id` = `user`.`id`")
            ->leftJoin("product", "`product_user`.`product_id` = `product`.`id`")
            ->where("`user`.`company_id`={$company_id} AND `company`.`id` IS NULL  AND `product`.`token` = '".$token."'")
            ->order("user.username ASC")
            ->queryAll();
        return json_encode($request);
    }
    
    /**
     *
     * @param integer $company_id
     * @param string $token
     * @param integer $user_id
     * @param string $name
     * @return string @soap
     */
    public function getUser($company_id, $token, $user_id = null, $name = null) {

        $product = ProductCompany::model()->with('product')->findByAttributes(
            array('company_id'=> $company_id), array('condition' => "product.token = '{$token}'")
        );
        
        if(!$product) return false;
        
        $userQuery = "";
        $userQuery = (!is_null($name)) ? "AND (LOWER(`user`.`name`) LIKE LOWER('%{$name}%'))" : $userQuery;
        $userQuery = (!is_null($user_id)) ? "AND `user`.`id` = '{$user_id}'" : $userQuery;
        
        $request = Yii::app()->db->createCommand()
            ->select("user.id, user.name, user.username, user.email, user.company_id, user.active, user.date_create")
            ->from("user")
            ->join("product_user", "`product_user`.`user_id` = `user`.`id`")
            ->leftJoin("company", "`company`.`user_id` = `user`.`id`")
            ->leftJoin("product", "`product_user`.`product_id` = `product`.`id`")
            ->where("`user`.`company_id`={$company_id} ".$userQuery." AND `product`.`token` = '".$token."'")
            ->order("user.username ASC")
            ->queryRow();
        return json_encode($request);
    }
    
    /**
     *
     * @param mixed $user
     * @param string $product
     * @return array
     */
    public static function getVars($user, $product = null) {
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

    /**
     *
     * @param integer $user_id
     * @param string $token
     * @return boolean @soap
     */
    public function validateProduct($user_id, $token) {
        $request = null;
        if ($user_id > 1) {
            $request = Yii::app()->db->createCommand()
                ->select("user_id")
                ->from("product_user")
                ->join("product p", "p.id=product_id AND p.token='{$token}'")
                ->where("user_id={$user_id}")
                ->limit("1")
                ->queryScalar();
        } else {
            if($token == Yii::app()->params->token) {
                return true;   
            }
        }
        return $request;
    }

   /**
     *
     * @param integer $user_id
     * @param string $token
     * @return boolean @soap
    */
    public function registerProductUser($user_id, $token) {
        
        $product = Product::model()->findByAttributes(array('token'=> $token));
        
        if(!$product) return false;
        
        $productUser = ProductUser::model()->findByAttributes(array('user_id'=>$user_id, 'product_id' => $product->id));
        
        if($productUser) {

            $productUser->is_used = '1';
        
            return $productUser->update() ? true : false;
        } else {
            return true;
        }
        
    }

   /**
     *
     * @param integer $user_id
     * @param string $token
     * @return boolean @soap
    */
    public function unregisterProductUser($user_id, $token) {
        
        $product = Product::model()->findByAttributes(array('token'=> $token));
        
        if(!$product) return false;
        
        $productUser = ProductUser::model()->findByAttributes(array('user_id'=>$user_id, 'product_id' => $product->id));
        
        if($productUser) {
            $productUser->is_used = false;

            return $productUser->update() ? true : false;
        } else {
            return true;
        }
        
    }


}