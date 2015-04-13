<?php

class ProductUserModel extends ProductUser {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function deleteByUser($id, $all = false) {
        if($all) {
            return self::model()->deleteAllByAttributes(array('user_id' => $id));
        } else {
            return self::model()->deleteAllByAttributes(array('user_id' => $id, 'is_used' => '0'));
        }
        
    }

}