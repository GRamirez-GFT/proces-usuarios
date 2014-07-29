<?php
/**
 * @property integer $product_id
 * @property integer $company_id
 */

class ProductCompany extends MyActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'product_company';
	}

	public function rules() {
		return array(
		array('product_id, company_id', 'required'),
		array('product_id, company_id', 'numerical', 'integerOnly' => true),
		array('product_id, company_id', 'safe', 'on' => 'search'),
		);
	}

	public function attributeLabels() {
		return array(
		'product_id' => 'product_id',
		'company_id' => 'company_id',
		);
	}

	public function search() {
		$criteria = new CDbCriteria;
		$criteria->compare('product_id', $this->product_id);
		$criteria->compare('company_id', $this->company_id);
		$sort = new CSort();
		$sort->attributes = array('*');
		$sort->multiSort = true;
		return new CActiveDataProvider($this, array('criteria' => $criteria, 'sort' => $sort));
	}
	
}