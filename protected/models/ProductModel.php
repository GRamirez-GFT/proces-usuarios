<?php

class ProductModel extends Product {

    public function init() {
        if (in_array(Yii::app()->user->role, array("company"))) {
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
        return parent::save();
    }

    public function update() {
        return parent::update();
    }

    public function delete() {
        return parent::deleteByPk($this->getPrimaryKey());
    }

}