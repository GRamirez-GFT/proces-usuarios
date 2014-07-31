<?php
/**
 * @property integer $id
 * @property string $name
 * @property string $subdomain
 * @property integer $user_id
 * @property boolean $active
 * @property string $date_create
 *
 * @property Product[] $product
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
		array('name, subdomain, user_id, active', 'required'),
		array('user_id, active', 'numerical', 'integerOnly' => true),
		array('active', 'boolean', 'allowEmpty' => true),
		array('name', 'length', 'max' => 100),
		array('subdomain', 'length', 'max' => 30),
		array('date_create', 'date', 'format' => 'dd/mm/yyyy'),
		array('date_create', 'default', 'value' => date('d/m/Y'), 'setOnEmpty' => false),
		array('id, name, subdomain, user_id, active, date_create', 'safe', 'on' => 'search'),
		);
	}

	public function relations() {
		return array(
		'product' => array(self::MANY_MANY, 'Product', 'product_company(company_id, product_id)'),
		);
	}
	
	public function attributeLabels() {
		return array(
		'id' => 'id',
		'name' => 'name',
		'subdomain' => 'subdomain',
		'user_id' => 'user_id',
		'active' => 'active',
		'date_create' => 'date_create',
		);
	}

	public function search() {
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('subdomain', $this->subdomain, true);
		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('active', $this->active);
		$criteria->compare('date_create', $this->date_create);
		$sort = new CSort();
		$sort->attributes = array('*');
		$sort->multiSort = true;
		return new CActiveDataProvider($this, array('criteria' => $criteria, 'sort' => $sort));
	}
	
}