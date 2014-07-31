<?php
/**
 * @property integer $id
 * @property string $name
 * @property string $url_product
 *
 * @property Company[] $companies
 * @property User[] $users
 */

class Product extends MyActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'product';
	}

	public function rules() {
		return array(
		array('name', 'required'),
		array('name', 'length', 'max' => 100),
		array('url_product', 'length', 'max' => 255),
		array('id, name, url_product', 'safe', 'on' => 'search'),
		);
	}

	public function relations() {
		return array(
		'companies' => array(self::MANY_MANY, 'Company', 'product_company(product_id, company_id)'),
		'users' => array(self::MANY_MANY, 'User', 'product_user(product_id, user_id)'),
		);
	}
	
	public function attributeLabels() {
		return array(
		'id' => 'id',
		'name' => 'name',
		'url_product' => 'url_product',
		);
	}

	public function search() {
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('url_product', $this->url_product, true);
		$sort = new CSort();
		$sort->attributes = array('*');
		$sort->multiSort = true;
		return new CActiveDataProvider($this, array('criteria' => $criteria, 'sort' => $sort));
	}
	
}