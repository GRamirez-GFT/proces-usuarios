<?php
/**
 * @property integer $id
 * @property string $name
 * @property string $subdomain
 * @property integer $user_id
 * @property boolean $active
 * @property string $date_create
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
		array('name, subdomain, user_id, active, date_create', 'required'),
		array('user_id, active', 'numerical', 'integerOnly' => true),
		array('name', 'length', 'max' => 100),
		array('subdomain', 'length', 'max' => 30),
		array('url_logo', 'length', 'max' => 200),
		array('user_id', 'exist', 'allowEmpty' => true, 'attributeName' => 'id', 'className' => 'User'),
		array('id, name, subdomain, user_id, url_logo, active, date_create', 'safe', 'on' => 'search'),
		);
	}

	public function relations() {
		return array(
		'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		'products' => array(self::HAS_MANY, 'Product', 'company_id'),
		'products1' => array(self::MANY_MANY, 'Product', 'product_company(company_id, product_id)'),
		'users' => array(self::HAS_MANY, 'User', 'company_id'),
		);
	}
	
	public function attributeLabels() {
		return array(
		'id' => Yii::t('models/Company', 'id'),
		'name' => Yii::t('models/Company', 'name'),
		'subdomain' => Yii::t('models/Company', 'subdomain'),
		'user_id' => Yii::t('models/Company', 'user_id'),
		'active' => Yii::t('models/Company', 'active'),
		'date_create' => Yii::t('models/Company', 'date_create'),
		'url_logo' => Yii::t('models/Company', 'url_logo'),
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