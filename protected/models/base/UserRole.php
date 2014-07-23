<?php
/**
 * @property integer $user_id
 * @property integer $role_id
 */

class UserRole extends MyActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'user_role';
	}

	public function rules() {
		return array(
		array('user_id, role_id', 'required'),
		array('user_id, role_id', 'numerical', 'integerOnly'=>true),
		array('user_id, role_id', 'safe', 'on' => 'search'),
		);
	}

	public function attributeLabels() {
		return array(
		'user_id' => 'user_id',
		'role_id' => 'role_id',
		);
	}

	public function search() {
		$criteria=new CDbCriteria;
		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('role_id', $this->role_id);
		$sort = new CSort();
		$sort->attributes = array('*');
		$sort->multiSort = true;
		return new CActiveDataProvider($this, array('criteria' => $criteria, 'sort' => $sort));
	}
	
}