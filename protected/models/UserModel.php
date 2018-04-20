<?php

class UserModel extends User {
    public $list_products;
    public $verify_password;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function init() {
        if ($this->isNewRecord && $this->getScenario() != 'search') {
            $this->active = 1;
        }
    }

    public function rules() {
        return CMap::mergeArray(parent::rules(),
            array(
                array('email','email'),
                array('password', 'required', 'on' => 'insert'),
                array('verify_password', 'ruleComparePassword'),
                array('password', 'checkStrength'),
                array('username', 'checkUniqueUsername'),
            ));
    }

    public function ruleComparePassword($attribute_name, $params) {
        
        if(!empty($this->password)) {
            if ($this->password != $this->verify_password) {
                $this->addError($attribute_name, 'Las contraseñas no coinciden.');
            }
        }
    }
    
    public function checkStrength($attribute_name, $params) {
        
        if(!empty($this->password)) {
            $score = 0;

            /* This validations should coincide with javascript front validations */
            if (strlen($this->password) > 6) $score++;

            if (preg_match('/[A-Z]/', $this->password) && preg_match('/[A-Z]/', $this->password)) $score++;

            if (preg_match('/\d+/', $this->password)){ $score++;}

            if (preg_match('/[^a-z\d]+/', $this->password) ) $score++;

            if (strlen($this->password) > 12) $score++;

            /* If less than medium */
            if($score < 3) {
                $this->addError($attribute_name, 'Debe tener nivel de seguridad Medio o mayor.');   
            }
        }
	   
    }
    
    public function checkUniqueUsername($attribute_name, $params) {

        if(Yii::app()->user->getState('role') == 'company') {
            $userExist = User::model()->find("username='".$this->username."' AND company_id='".Yii::app()->user->company_id."'");

            if($userExist) {
                if(($userExist->id != $this->id && !empty($this->id)) || empty($this->id)) {
                    $this->addError($attribute_name, 'El alias ingresado ya se ecnuentra en uso.');  
                }
            }
        }
           
    }

    public function attributeLabels() {
        return CMap::mergeArray(parent::attributeLabels(),
            array(
                'list_products' => Yii::t('models/User', 'list_products'),
                'verify_password' => Yii::t('models/User', 'verify_password'),
            ));
    }
    
    public function setAttributes($values, $safeOnly = true) {
        if (! is_array($values)) return;
        foreach ($values as $name => $value) {
            if ($name == 'id') continue;
            $this->setAttribute($name, $value);
        }
    }

    public function save($runValidation = true, $attributes = null) {
        $success = false;
        try {
            $transaction = Yii::app()->db->getCurrentTransaction() ? null : Yii::app()->db->beginTransaction();
            
            $this->date_create = date('Y-m-d');
            $this->active =  1;
            if(Yii::app()->user->getState('role') == 'company') {
                $this->company_id = Yii::app()->user->company_id;
            }
            
            if ($success = parent::save()) {
                if (is_array($this->list_products)) {
                    foreach ($this->list_products as $item) {
                        if (! ProductCompany::model()->exists('company_id=:t0 AND product_id=:t1',
                            array(
                                ':t0' => $this->company_id,
                                ':t1' => $item
                            ))) continue;
                        $product = new ProductUser();
                        $product->product_id = $item;
                        $product->user_id = $this->id;
                        $product->is_used = '0';
                        if (! ($success = $product->save())) break;
                    }
                }
            }
            if ($success) {
                $transaction ? $transaction->commit() : null;
            }
        } catch (Exception $e) {
            $transaction ? $transaction->rollback() : null;
        }
        return $success;
    }

    public function update($attributes = null) {
        $success = false;
        try {
            $transaction = Yii::app()->db->getCurrentTransaction() ? null : Yii::app()->db->beginTransaction();

            $attributes = self::validateAttributes($attributes);

            if ($success = parent::update($attributes)) {
                if(is_array($this->list_products)) {
/*                  
*               #### Lógica usada ####
*
*                TENGO
*                A, B, C
*
*                ENVIO
*                A, C, D 
*
*                NUEVO ¿Cuales de "ENVIO" no estan en "TENGO"? Y por lo tanto voy a agregar
*                D
*
*                YA TENGO ¿Cuales de "TENGO" estan en "ENVIO"? Da el mismo resultado que "NUEVO"
*                A, C ---> Quito de "ENVIO"
*                D    ---> Me queda para agregar 
*
*                QUITO DE "TENGO" ¿Cuales de TENGO no estan en ENVIO? Y por lo tanto voy a quitar
*                B --- 
*/
                    foreach($this->products as $product) {
                        if(in_array($product->id, $this->list_products)) {
                            $idKey = array_search($product->id, $this->list_products);
                            unset($this->list_products[$idKey]); 
                        } else {
                            $productUserDeleted = ProductUser::model()->deleteAllByAttributes(
                                array(
                                    'user_id' => $this->id,
                                    'product_id' => $product->id,
                                    'is_used' => 0
                                ));
                            if(!$productUserDeleted) {
                                $this->addError('list_products', Yii::t('models/User', 'Some products are in use and cant be deleted.'));   
                                $success = false;
                                break;
                            }
                        }
                    }

                    if ($success) {
                        foreach ($this->list_products as $product_id) {
                            if (! ProductCompany::model()->exists('company_id=:t0 AND product_id=:t1',
                                array(
                                    ':t0' => $this->company_id,
                                    ':t1' => $product_id
                                ))) continue;
                            $product = new ProductUser();
                            $product->product_id = $product_id;
                            $product->user_id = $this->id;
                            if (! ($success = $product->save())) break;
                        }
                    }
                }
            }
            if ($success) {
                $transaction ? $transaction->commit() : null;
            }
        } catch (Exception $e) {
            $transaction ? $transaction->rollback() : null;
        }
        return $success;
    }

    public function delete() {

        $success = false;
        try {
            $transaction = Yii::app()->db->getCurrentTransaction() ? null : Yii::app()->db->beginTransaction();
            
            ProductUserModel::deleteByUser($this->id, false);

            $success = parent::delete();
            
            if ($success) {
                $transaction ? $transaction->commit() : null;
            }
        } catch (Exception $e) {
            $transaction ? $transaction->rollback() : null;
        }
        return $success;

    }

    private function validateAttributes($attributes) {

        $validatedAttributes = array();

        if(is_null($attributes)) {
            foreach ($this->getAttributes() as $name => $value) {
                if ($value != ""  && $name != 'id') {
                    $validatedAttributes[] = $name;
                }
            }
        } else {
             foreach ($this->getAttributes() as $name => $value) {
                if (($value == ""  || $name == 'id') && array_key_exists($name, $attributes)) {
                    unset($attributes[$name]);
                }
            }

            $validatedAttributes = $attributes;
        }

        return $validatedAttributes;
    }

    public function afterFind() {
        parent::afterFind();
        foreach ($this->products as $item) {
            $this->list_products[] = $item->id;
        }
    }
    
    public function search() {
        $criteria = new CDbCriteria();
        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('company_id', Yii::app()->user->company_id);
        $sort = new CSort();
        $sort->attributes = array(
            '*'
        );
        $sort->multiSort = true;
        return new CActiveDataProvider($this,
            array(
                'criteria' => $criteria,
                'sort' => $sort
            ));
    }

	public function generateOneStepSessionToken($forceUpdate = false) {

		if(empty($this->one_step_session_token) || $forceUpdate) {
			$this->one_step_session_token = uniqid() . substr(md5(Yii::app()->user->getStateKeyPrefix()), 0, 8);
		}

	}
	
}