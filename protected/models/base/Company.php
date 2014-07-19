<?php
/**
 * @property integer $id
 * @property string $name
 * @property string $subdomain
 * @property boolean $active
 * @property string $date_create
 *
 * @property Product[] $products
 */

class Company extends MyActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'company';
	}

	public function rules() {
		return array(
		array('name', 'required'),
		array('active', 'boolean', 'allowEmpty' => true),
		array('name', 'length', 'max' => 100),
		array('subdomain', 'length', 'max' => 30),
		array('active', 'length', 'max' => 1),
		array('id, name, subdomain, active, date_create', 'safe', 'on' => 'search'),
		);
	}

	public function relations() {
		return array(
		'products' => array(self::MANY_MANY, 'Product', 'company_product(company_id, product_id)'),
		);
	}
	
	public function attributeLabels() {
		return array(
		'id' => 'id',
		'name' => 'name',
		'subdomain' => 'subdomain',
		'active' => 'active',
		'date_create' => 'date_create',
		);
	}

	public function search() {
		$criteria=new CDbCriteria;
		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('subdomain', $this->subdomain, true);
		$criteria->compare('active', $this->active);
		$criteria->compare('date_create', $this->date_create);
		$sort = new CSort();
		$sort->attributes = array('*');
		$sort->multiSort = true;
		return new CActiveDataProvider($this, array('criteria' => $criteria, 'sort' => $sort));
	}
	
}