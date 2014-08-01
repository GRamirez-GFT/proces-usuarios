<?php

class UserModel extends User {
    public $list_products;
    public $verify_password;

    public function init() {
        if (in_array(Yii::app()->user->role, array("company"))) {
            $this->company_id = Yii::app()->user->company_id;
        }
        if ($this->getScenario() == 'insert') {
            $this->active = 1;
        }
    }

    public function rules() {
        return CMap::mergeArray(parent::rules(),
            array(
                array(
                    'verify_password, password',
                    'required'
                ),
                array(
                    'verify_password',
                    'ruleComparePassword'
                )
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
                'list_products' => 'list_products',
                'verify_password' => 'verify_password'
            ));
    }

    public function setAttributes($values) {
        if (! is_array($values)) return;
        foreach ($values as $name => $value) {
            if ($name == 'id') continue;
            $this->setAttribute($name, $value);
        }
    }

    public function load($id) {
        $this->setIsNewRecord(false);
        $this->setScenario(Yii::app()->getController()
            ->getAction()
            ->getId());
        if ($model = parent::model()->findByPk($id)) {
            $this->id = $id;
            $this->setAttributes($model->getAttributes());
            foreach ($this->products as $item) {
                $this->list_products[] = $item->id;
            }
            $this->password = null;
            return true;
        }
        return false;
    }

    public function save() {
        $success = false;
        try {
            $transaction = Yii::app()->db->getCurrentTransaction() ? null : Yii::app()->db->beginTransaction();
            $this->date_create = date('Y-m-d');
            if ($success = parent::save()) {
                if (is_array($this->list_products)) {
                    foreach ($this->list_products as $item) {
                        if (! ProductCompany::model()->exists('company_id=:t0 AND product_id=:t1',
                            array(
                                ':t0' => $this->company_id,
                                ':t1' => $item
                            ))) continue;
                        $procut = new ProductUser();
                        $procut->product_id = $item;
                        $procut->user_id = $this->id;
                        if (! ($success = $procut->save())) break;
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
            if ($success = $this->validate()) {
                ProductUser::model()->deleteAllByAttributes(
                    array(
                        'user_id' => $this->id
                    ));
                $success = parent::update();
                if (is_array($this->list_products)) {
                    foreach ($this->list_products as $item) {
                        if (! ProductCompany::model()->exists('company_id=:t0 AND product_id=:t1',
                            array(
                                ':t0' => $this->company_id,
                                ':t1' => $item
                            ))) continue;
                        $procut = new ProductUser();
                        $procut->product_id = $item;
                        $procut->user_id = $this->id;
                        if (! ($success = $procut->save())) break;
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

}