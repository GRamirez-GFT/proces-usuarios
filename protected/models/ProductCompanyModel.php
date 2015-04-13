<?php

class ProductCompanyModel extends ProductCompany {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function deleteByCompany($id) {

        return self::model()->deleteAllByAttributes(array('company_id' => $id));
        
    }

}