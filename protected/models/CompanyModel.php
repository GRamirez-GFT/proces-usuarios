<?php

class CompanyModel extends Company {
    public $list_products;
    public $_user;

    public function init() {
        if ($this->getScenario() == 'insert') {
            $this->active = 1;
        }
        $this->_user = new UserModel();
    }

    public function attributeLabels() {
        return CMap::mergeArray(parent::attributeLabels(),
            array(
                'list_products' => 'list_products'
            ));
    }

    public function setAttributes($values) {
        if (! is_array($values)) return;
        foreach ($values as $name => $value) {
            if ($name == 'id') continue;
            $this->setAttribute($name, $value);
        }
        $this->_user->setAttributes(Yii::app()->request->getParam(get_class($this->_user)));
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
            $this->_user->load($this->user_id);
            return true;
        }
        return false;
    }

    public function save() {
        $success = false;
        try {
            $transaction = Yii::app()->db->getCurrentTransaction() ? null : Yii::app()->db->beginTransaction();
            $this->date_create = date('Y-m-d');
            if ($success = $this->_user->save()) {
                $this->user_id = $this->_user->id;
                if ($success = parent::save()) {
                    if ($success = $this->_user->updateByPk($this->_user->id,
                        array(
                            'company_id' => $this->id
                        ))) {
                        if (is_array($this->list_products)) {
                            foreach ($this->list_products as $item) {
                                $procut_user = new ProductUser();
                                $procut_user->user_id = $this->_user->id;
                                $procut_user->product_id = $item;
                                if (! ($success = $procut_user->save())) break;
                                $procut_comp = new ProductCompany();
                                $procut_comp->product_id = $item;
                                $procut_comp->company_id = $this->id;
                                if (! ($success = $procut_comp->save())) break;
                            }
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

    public function update() {
        $success = false;
        try {
            $transaction = Yii::app()->db->getCurrentTransaction() ? null : Yii::app()->db->beginTransaction();
            if ($success = $this->validate()) {
                ProductCompany::model()->deleteAllByAttributes(
                    array(
                        'company_id' => $this->id
                    ));
                ProductUser::model()->deleteAllByAttributes(
                    array(
                        'user_id' => $this->user_id
                    ));
                $success = parent::update();
                $success = $this->_user->update();
                User::model()->updateAll(array(
                    'active' => $this->active
                ), array(
                    'condition' => "company_id={$this->id}"
                ));
                if (is_array($this->list_products)) {
                    foreach ($this->list_products as $item) {
                        $procut_user = new ProductUser();
                        $procut_user->user_id = $this->_user->id;
                        $procut_user->product_id = $item;
                        if (! ($success = $procut_user->save())) break;
                        $procut_comp = new ProductCompany();
                        $procut_comp->product_id = $item;
                        $procut_comp->company_id = $this->id;
                        if (! ($success = $procut_comp->save())) break;
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
        return parent::deleteByPk($this->getPrimaryKey());
    }

}