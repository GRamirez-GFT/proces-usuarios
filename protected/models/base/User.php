<?php
/**
 * @property integer $id
 * @property string $name
 * @property string $username
 * @property string $password
 * @property integer $company_id
 * @property boolean $active
 * @property string $date_create
 *
 * @property Action[] $actions
 * @property Company[] $companies
 * @property Product[] $products
 * @property Company $company
 * @property UserSession[] $userSessions
 */

class User extends MyActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'user';
	}

	public function rules() {
		return array(
		array('name, username, password, date_create', 'required'),
		array('company_id, active', 'numerical', 'integerOnly' => true),
		array('name', 'length', 'max' => 100),
		array('username', 'length', 'max' => 32),
		array('password', 'length', 'max' => 72),
		array('company_id', 'exist', 'allowEmpty' => true, 'attributeName' => 'id', 'className' => 'Company'),
		array('id, name, username, password, company_id, active, date_create', 'safe', 'on' => 'search'),
		);
	}

	public function relations() {
		return array(
		'actions' => array(self::MANY_MANY, 'Action', 'action_user(user_id, action_id)'),
		'companies' => array(self::HAS_MANY, 'Company', 'user_id'),
		'products' => array(self::MANY_MANY, 'Product', 'product_user(user_id, product_id)'),
		'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
		'userSessions' => array(self::HAS_MANY, 'UserSession', 'user_id'),
		);
	}
	
	public function attributeLabels() {
		return array(
		'id' => 'id',
		'name' => 'name',
		'username' => 'username',
		'password' => 'password',
		'company_id' => 'company_id',
		'active' => 'active',
		'date_create' => 'date_create',
		);
	}

	public function search() {
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('username', $this->username, true);
		$criteria->compare('password', $this->password, true);
		$criteria->compare('company_id', $this->company_id);
		$criteria->compare('active', $this->active);
		$criteria->compare('date_create', $this->date_create);
		$sort = new CSort();
		$sort->attributes = array('*');
		$sort->multiSort = true;
		return new CActiveDataProvider($this, array('criteria' => $criteria, 'sort' => $sort));
	}
	
}