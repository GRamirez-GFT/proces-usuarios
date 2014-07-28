<?php
/**
 * @property integer $id
 * @property string $name
 * @property string $username
 * @property string $password
 * @property boolean $active
 * @property string $date_create
 * @property integer $company_id
 *
 * @property Action[] $actions
 * @property UserType[] $userTypes
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
		array('name, username, password, active, date_create', 'required'),
		array('company_id', 'numerical', 'integerOnly'=>true),
		array('active', 'boolean', 'allowEmpty' => true),
		array('name', 'length', 'max'=>100),
		array('username', 'length', 'max'=>32),
		array('password', 'length', 'max'=>72),
		array('company_id', 'exist', 'allowEmpty' => true, 'attributeName' => 'id', 'className' => 'Company'),
		array('id, name, username, password, active, date_create, company_id', 'safe', 'on' => 'search'),
		);
	}

	public function relations() {
		return array(
		'actions' => array(self::MANY_MANY, 'Action', 'action_user(user_id, action_id)'),
		'userTypes' => array(self::MANY_MANY, 'UserType', 'product_user(user_id, user_type_id)'),
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
		'active' => 'active',
		'date_create' => 'date_create',
		'company_id' => 'company_id',
		);
	}

	public function search() {
		$criteria=new CDbCriteria;
		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('username', $this->username, true);
		$criteria->compare('password', $this->password, true);
		$criteria->compare('active', $this->active);
		$criteria->compare('date_create', $this->date_create);
		$criteria->compare('company_id', $this->company_id);
		$sort = new CSort();
		$sort->attributes = array('*');
		$sort->multiSort = true;
		return new CActiveDataProvider($this, array('criteria' => $criteria, 'sort' => $sort));
	}
	
}