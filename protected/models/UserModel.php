<?php

class UserModel extends User {

    public function load($id) {
        if ($model = parent::model()->findByPk($id)) {
            $this->id = $id;
            $this->setAttributes($model->getAttributes());
            return true;
        }
        return false;
    }

}