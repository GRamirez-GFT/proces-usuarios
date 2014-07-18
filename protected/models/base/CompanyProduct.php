<?php
/**
 * @property integer $company_id
 * @property integer $product_id
 * @property string $date_create
 *
 * @property Company $company
 * @property Product $product
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
		array('company_id, product_id', 'required'),
		array('company_id, product_id', 'numerical', 'integerOnly' => true),
		array('company_id', 'exist', 'allowEmpty' => true, 'attributeName' => 'id', 'className' => 'Company'),
		array('product_id', 'exist', 'allowEmpty' => true, 'attributeName' => 'id', 'className' => 'Product'),
		array('company_id, product_id, date_create', 'safe', 'on' => 'search'),
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