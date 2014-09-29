<?php

class CompanyModel extends Company {
    public $list_products;
    public $user;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function init() {
        if ($this->isNewRecord && $this->getScenario() != 'search') {
            $this->user = new UserModel();
            $this->active = 1;
        }
    }

    public function rules() {
        return CMap::mergeArray(parent::rules(),
            array(
                array('name, subdomain, user_id', 'required', 'on' => 'update'),
                array('url_logo', 'file', 'types'=>'jpg, png', 'allowEmpty' => true),
            ));
    }

    public function attributeLabels() {
        return CMap::mergeArray(parent::attributeLabels(),
            array(
                'list_products' => Yii::t('models/Company', 'list_products'),
            ));
    }

    public function setAttributes($values) {
        if (! is_array($values)) return;
        foreach ($values as $name => $value) {
            if ($name == 'id') continue;
            $this->setAttribute($name, $value);
        }
        $this->user->setAttributes(Yii::app()->request->getParam(get_class($this->user)));
    }

    public function save() {
        $success = false;
        try {
            $transaction = Yii::app()->db->getCurrentTransaction() ? null : Yii::app()->db->beginTransaction();
            $this->date_create = date('Y-m-d');
            if ($success = $this->user->save()) {
                $this->user_id = $this->user->id;
                if ($success = parent::save()) {
                    if ($success = $this->user->updateByPk($this->user->id,
                        array(
                            'company_id' => $this->id
                        ))) {
                        if (is_array($this->list_products)) {
                            foreach ($this->list_products as $item) {
                                $product_user = new ProductUser();
                                $product_user->product_id = $item;
                                $product_user->user_id = $this->user->id;
                                if (! ($success = $product_user->save())) break;
                                $product_comp = new ProductCompany();
                                $product_comp->product_id = $item;
                                $product_comp->company_id = $this->id;
                                if (! ($success = $product_comp->save())) break;
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
                foreach (ProductCompany::model()->findAll(
                    array(
                        'condition' => 't.company_id=:t0',
                        'join' => 'JOIN product p ON p.id=t.product_id AND p.company_id IS NULL',
                        'params' => array(
                            ':t0' => $this->id
                        )
                    )) as $item) {
                    ProductCompany::model()->deleteAllByAttributes(
                        array(
                            'product_id' => $item->product_id,
                            'company_id' => $this->id
                        ));
                    ProductUser::model()->deleteAllByAttributes(
                        array(
                            'product_id' => $item->product_id,
                            'user_id' => $this->user_id
                        ));
                }
                parent::update();
                $this->user->update();
                User::model()->updateAll(array(
                    'active' => $this->active
                ), array(
                    'condition' => "company_id={$this->id}"
                ));
                if (is_array($this->list_products)) {
                    foreach ($this->list_products as $item) {
                        $product_user = new ProductUser();
                        $product_user->user_id = $this->user->id;
                        $product_user->product_id = $item;
                        if (! ($success = $product_user->save())) break;
                        $product_comp = new ProductCompany();
                        $product_comp->product_id = $item;
                        $product_comp->company_id = $this->id;
                        if (! ($success = $product_comp->save())) break;
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

    public function afterFind() {
        parent::afterFind();
        foreach ($this->products1 as $item) {
            $this->list_products[] = $item->id;
        }
        $this->user = UserModel::model()->findByPk($this->user_id);
    }

}