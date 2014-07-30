<?php

class CompanyModel extends Company {
    public $list_products;

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
            if ($success = parent::save()) {
                foreach ($this->list_products as $item) {
                    $procut = new ProductCompany();
                    $procut->product_id = $item;
                    $procut->company_id = $this->id;
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
            $success = parent::update();
            ProductCompany::model()->deleteAllByAttributes(array(
                'company_id' => $this->id
            ));
            foreach ($this->list_products as $item) {
                $procut = new ProductCompany();
                $procut->product_id = $item;
                $procut->company_id = $this->id;
                if (! ($success = $procut->save())) break;
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