<?php

class UserModel extends User {
    public $list_products;
    public $verify_password;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function init() {
        if (in_array(Yii::app()->user->role, array(
            "company"
        ))) {
            $this->company_id = Yii::app()->user->company_id;
        }
        if ($this->isNewRecord && $this->getScenario() != 'search') {
            $this->active = 1;
        }
    }

    public function rules() {
        return CMap::mergeArray(parent::rules(),
            array(
                array(
                    'email',
                    'email'
                ),
                array(
                    'verify_password, password',
                    'required'
                ),
                array(
                    'verify_password',
                    'ruleComparePassword'
                ),
                array('name, username', 'required', 'on' => 'update'),
            ));
    }

    public function ruleComparePassword($attribute_name, $params) {
        if ($this->password != $this->verify_password) {
            $this->addError($attribute_name, Yii::t('base', 'passwords not match'));
        }
    }

    public function attributeLabels() {
        return CMap::mergeArray(parent::attributeLabels(),
            array(
                'list_products' => Yii::t('models/User', 'list_products'),
                'verify_password' => Yii::t('models/User', 'verify_password'),
            ));
    }

    public function setAttributes($values) {
        if (! is_array($values)) return;
        foreach ($values as $name => $value) {
            if ($name == 'id') continue;
            $this->setAttribute($name, $value);
        }
    }

    public function save() {
        $success = false;
        try {
            $transaction = Yii::app()->db->getCurrentTransaction() ? null : Yii::app()->db->beginTransaction();
            $this->date_create = date('Y-m-d');
            $this->active =  true;
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
                        if (! ($success = $product->save())) break;
                    }
                }
            }
            if ($success) {
                $transaction ? $transaction->commit() : null;
            }
        } catch (Exception $e) {
            $transaction ? $transaction->commit() : null;
        }
        return $success;
    }

    public function update() {
        $success = false;
        try {
            $transaction = Yii::app()->db->getCurrentTransaction() ? null : Yii::app()->db->beginTransaction();
            $attributes = array();
            foreach ($this->getAttributes() as $name => $value) {
                if ($value && $name != 'id') {
                    $attributes[] = $name;
                }
            }
            if ($success = parent::update($attributes)) {
                ProductUser::model()->deleteAllByAttributes(
                    array(
                        'user_id' => $this->id
                    ));
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
                        if (! ($success = $product->save())) break;
                    }
                }
            }
            if ($success) {
                $transaction ? $transaction->commit() : null;
            }
        } catch (Exception $e) {
            $transaction ? $transaction->commit() : null;
        }
        return $success;
    }

    public function delete() {
        return parent::deleteByPk($this->getPrimaryKey());
    }

    public function afterFind() {
        parent::afterFind();
        foreach ($this->products as $item) {
            $this->list_products[] = $item->id;
        }
    }

}