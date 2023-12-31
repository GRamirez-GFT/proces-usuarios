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

	public function relations() {
		return array(
		'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
        'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
		);
	}

	public function attributeLabels() {
		return array(
		'product_id' => Yii::t('models/ProductCompany', 'product_id'),
		'company_id' => Yii::t('models/ProductCompany', 'company_id'),
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