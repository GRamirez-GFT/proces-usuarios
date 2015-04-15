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
     * @param string $username
     * @param string $password
     * @param string $company
     * @return string @soap
     */
    public function login($username, $password, $company) {

        if ($company) {
            $user = User::model()->with(
                array(
                    "company" => array(
                        "condition" => "subdomain='{$company}'"
                    )
                ))->findByAttributes(
                array(
                    "active" => 1
                ), array('condition' => "(`t`.`username`='{$username}' OR `t`.`email`='{$username}')"));
        } else {
            $user = User::model()->findByAttributes(
                array(
                    "id" => 1,
                    "username" => $username,
                    "active" => 1
                ));
        }
        if ($user) {
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
            $request["company"] = $user->company->name;
            $request["subdomain"] = $user->company->subdomain;
            $request["url_logo"] = "http://" . $_SERVER['HTTP_HOST'] . Yii::app()->baseUrl.DIRECTORY_SEPARATOR.$user->company->url_logo;
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
            $request = Yii::app()->db->createCommand()
                ->select("id")
                ->from("product")
                ->where("token='{$token}' AND company_id IS NULL")
                ->limit("1")
                ->queryScalar();
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
        
        $productUser = ProductUser::model()->findByAttributes(array('user_id'=>$user_id));

        if($productUser) {
            $productUser->is_used = true;

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
        
        $productUser = ProductUser::model()->findByAttributes(array('user_id'=>$user_id));
        
        if($productUser) {
            $productUser->is_used = false;

            return $productUser->update() ? true : false;
        } else {
            return true;
        }
        
    }


}