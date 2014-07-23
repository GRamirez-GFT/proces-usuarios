<?php
/**
 * @property integer $company_id
 * @property integer $product_id
 * @property string $date_create
 */

class CompanyProduct extends MyActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'company_product';
	}

	public function rules() {
		return array(
		array('company_id, product_id, date_create', 'required'),
		array('company_id, product_id', 'numerical', 'integerOnly'=>true),
		array('company_id, product_id, date_create', 'safe', 'on' => 'search'),
		);
	}

	public function attributeLabels() {
		return array(
		'company_id' => 'company_id',
		'product_id' => 'product_id',
		'date_create' => 'date_create',
		);
	}

	public function search() {
		$criteria=new CDbCriteria;
		$criteria->compare('company_id', $this->company_id);
		$criteria->compare('product_id', $this->product_id);
		$criteria->compare('date_create', $this->date_create);
		$sort = new CSort();
		$sort->attributes = array('*');
		$sort->multiSort = true;
		return new CActiveDataProvider($this, array('criteria' => $criteria, 'sort' => $sort));
	}
	
}