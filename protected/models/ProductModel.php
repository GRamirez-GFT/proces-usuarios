<?php

class ProductModel extends Product {

    public function init() {
        if (in_array(Yii::app()->user->role, array(
            "company"
        ))) {
            $this->company_id = Yii::app()->user->company_id;
        }
    }

    public function attributeLabels() {
        return CMap::mergeArray(parent::attributeLabels(), array());
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
            return true;
        }
        return false;
    }

    public function save() {
        $success = false;
        try {
            $transaction = Yii::app()->db->getCurrentTransaction() ? null : Yii::app()->db->beginTransaction();
            if ($this->isNewRecord) {
                $latest = Yii::app()->db->createCommand()
                    ->select('MAX(id)')
                    ->from('product')
                    ->limit('1')
                    ->queryScalar();
                $this->token = strtoupper(hash('crc32b', time()) . hash('crc32b', $latest + 1));
            }
            if ($success = parent::save()) {
                if ($this->company_id) {
                    $product_user = new ProductUser();
                    $product_user->product_id = $this->id;
                    $product_user->user_id = $this->company->user_id;
                    if ($success = $product_user->save()) {
                        $product_comp = new ProductCompany();
                        $product_comp->product_id = $this->id;
                        $product_comp->company_id = $this->company_id;
                        $success = $product_comp->save();
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
        return parent::update();
    }

    public function delete() {
        return parent::deleteByPk($this->getPrimaryKey());
    }

    public function search() {
        $criteria = new CDbCriteria();
        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('url_product', $this->url_product, true);
        if (isset(Yii::app()->user->company_id)) {
            $criteria->compare('company_id', Yii::app()->user->company_id);
        } else {
            $criteria->addCondition('company_id IS NULL');
        }
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

}