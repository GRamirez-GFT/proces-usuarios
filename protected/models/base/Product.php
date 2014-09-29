<?php
/**
 * @property integer $id
 * @property string $name
 * @property string $url_product
 * @property integer $company_id
 * @property string $token
 *
 * @property Company $company
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
		array('name, token', 'required'),
		array('company_id', 'numerical', 'integerOnly' => true),
		array('name', 'length', 'max' => 100),
		array('url_product', 'length', 'max' => 255),
		array('token', 'length', 'max' => 16),
		array('company_id', 'exist', 'allowEmpty' => true, 'attributeName' => 'id', 'className' => 'Company'),
		array('id, name, url_product, company_id, token', 'safe', 'on' => 'search'),
		);
	}

	public function relations() {
		return array(
		'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
		'companies' => array(self::MANY_MANY, 'Company', 'product_company(product_id, company_id)'),
		'users' => array(self::MANY_MANY, 'User', 'product_user(product_id, user_id)'),
		);
	}
	
	public function attributeLabels() {
		return array(
		'id' => Yii::t('models/Product', 'id'),
		'name' => Yii::t('models/Product', 'name'),
		'url_product' => Yii::t('models/Product', 'url_product'),
		'company_id' => Yii::t('models/Product', 'company_id'),
		'token' => Yii::t('models/Product', 'token'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('url_product', $this->url_product, true);
		$criteria->compare('company_id', $this->company_id);
		$criteria->compare('token', $this->token, true);
		$sort = new CSort();
		$sort->attributes = array('*');
		$sort->multiSort = true;
		return new CActiveDataProvider($this, array('criteria' => $criteria, 'sort' => $sort));
	}
	
}