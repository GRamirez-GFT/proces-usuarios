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
            if ($success) {
                $transaction->commit();
            }
        } catch (Exception $e) {
            $transaction->rollback();
        }
        return $success;
    }

}