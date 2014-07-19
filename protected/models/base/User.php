<?php
/**
 * @property integer $id
 * @property string $name
 * @property string $username
 * @property string $password
 * @property boolean $active
 * @property string $date_create
 *
 * @property Role[] $roles
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
		array('name, username, password', 'required'),
		array('active', 'boolean', 'allowEmpty' => true),
		array('name', 'length', 'max' => 100),
		array('username', 'length', 'max' => 32),
		array('password', 'length', 'max' => 72),
		array('active', 'length', 'max' => 1),
		array('id, name, username, password, active, date_create', 'safe', 'on' => 'search'),
		);
	}

	public function relations() {
		return array(
		'roles' => array(self::MANY_MANY, 'Role', 'user_role(user_id, role_id)'),
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
		$sort = new CSort();
		$sort->attributes = array('*');
		$sort->multiSort = true;
		return new CActiveDataProvider($this, array('criteria' => $criteria, 'sort' => $sort));
	}
	
}