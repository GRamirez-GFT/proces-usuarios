<?php

class MyActiveRecord extends CActiveRecord {

    public function beforeSave() {
        foreach ($this->metaData->columns as $column => $data) {
            switch ($data->name) {
                case 'password':
                    $this->setAttribute($data->name, CPasswordHelper::hashPassword($this->getAttribute($data->name)));
                break;
                default:
            }
        }
        return parent::beforeSave();
    }

}
