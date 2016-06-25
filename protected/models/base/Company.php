<?php
/**
 * @property integer $id
 * @property string $name
 * @property string $subdomain
 * @property integer $user_id
 * @property boolean $active
 * @property boolean $restrict_connection
 * @property string $date_create
 * @property integer $licenses
 *
 * @property User $user
 * @property Product[] $products
 * @property Product[] $products1
 * @property User[] $users
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
		array('name, subdomain, user_id, active, date_create, licenses', 'required'),
		array('user_id, active, restrict_connection, licenses', 'numerical', 'integerOnly' => true),
		array('name', 'length', 'max' => 100),
		array('subdomain', 'length', 'max' => 30),
		array('url_logo', 'length', 'max' => 200),
		array('user_id', 'exist', 'allowEmpty' => true, 'attributeName' => 'id', 'className' => 'User'),
		array('id, name, subdomain, user_id, url_logo, active, restrict_connection, date_create', 'safe', 'on' => 'search'),
		);
	}

	public function relations() {
		return array(
		'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		'products' => array(self::HAS_MANY, 'Product', 'company_id'),
		'products1' => array(self::MANY_MANY, 'Product', 'product_company(company_id, product_id)'),
		'users' => array(self::HAS_MANY, 'User', 'company_id'),
		'ips' => array(self::HAS_MANY, 'AllowedIp', 'company_id'),
		);
	}
	
	public function attributeLabels() {
		return array(
		'id' => Yii::t('models/Company', 'id'),
		'name' => Yii::t('models/Company', 'name'),
		'subdomain' => Yii::t('models/Company', 'subdomain'),
		'user_id' => Yii::t('models/Company', 'user_id'),
		'url_logo' => Yii::t('models/Company', 'url_logo'),
		'active' => Yii::t('models/Company', 'active'),
		'restrict_connection' => Yii::t('models/Company', 'restrict_connection'),
		'date_create' => Yii::t('models/Company', 'date_create'),
		'restrict_connection' => Yii::t('models/Company', 'restrict_connection'),
		'licenses' => Yii::t('models/Company', 'licenses'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('subdomain', $this->subdomain, true);
		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('active', $this->active);
		$criteria->compare('restrict_connection', $this->restrict_connection);
		$criteria->compare('date_create', $this->date_create);
		$sort = new CSort();
		$sort->attributes = array('*');
		$sort->multiSort = true;
		return new CActiveDataProvider($this, array('criteria' => $criteria, 'sort' => $sort));
	}
	
}