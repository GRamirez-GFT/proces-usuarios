<?php

class UserModel extends User {
    public $list_products;
    public $verify_password;

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
            return true;
        }
        return false;
    }

    public function save() {
        $success = false;
        try {
            $transaction = Yii::app()->db->getCurrentTransaction() ? Yii::app()->db->getCurrentTransaction() : Yii::app()->db->beginTransaction();
            $this->date_create = date('Y-m-d');
            $this->password = CPasswordHelper::hashPassword($this->password);
            if ($success = parent::save()) {
                foreach ($this->list_products as $item) {
                    $procut = new ProductUser();
                    $procut->product_id = $item;
                    $procut->user_id = $this->id;
                    if (! ($success = $procut->save())) break;
                }
            }
            if ($success) {
                $transaction->commit();
            }
        } catch (Exception $e) {
            $transaction->rollback();
        }
        return $success;
    }

    public function update() {
        $success = false;
        try {
            $transaction = Yii::app()->db->getCurrentTransaction() ? Yii::app()->db->getCurrentTransaction() : Yii::app()->db->beginTransaction();
            if ($success = $this->validate()) {
                $success = parent::update();
                ProductUser::model()->deleteAllByAttributes(
                    array(
                        'user_id' => $this->id
                    ));
                if (is_array($this->list_products)) {
                    foreach ($this->list_products as $item) {
                        $procut = new ProductUser();
                        $procut->product_id = $item;
                        $procut->user_id = $this->id;
                        if (! ($success = $procut->save())) break;
                    }
                }
            }
            if ($success) {
                $transaction->commit();
            }
        } catch (Exception $e) {
            $transaction->rollback();
        }
        return $success;
    }

    public function delete() {
        return parent::deleteByPk($this->getPrimaryKey());
    }

}