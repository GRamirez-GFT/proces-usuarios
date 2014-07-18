<?php
/**
 * @property integer $action_id
 * @property integer $role_id
 *
 * @property Role $role
 * @property Action $action
 */

class ActionRole extends MyActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'action_role';
	}

	public function rules() {
		return array(
		array('action_id, role_id', 'required'),
		array('action_id, role_id', 'numerical', 'integerOnly' => true),
		array('role_id', 'exist', 'allowEmpty' => true, 'attributeName' => 'id', 'className' => 'Role'),
		array('action_id', 'exist', 'allowEmpty' => true, 'attributeName' => 'id', 'className' => 'Action'),
		array('action_id, role_id', 'safe', 'on' => 'search'),
		);
	}

	public function relations() {
		return array(
		'role' => array(self::BELONGS_TO, 'Role', 'role_id'),
		'action' => array(self::BELONGS_TO, 'Action', 'action_id'),
		);
	}
	
	public function attributeLabels() {
		return array(
		'action_id' => 'action_id',
		'role_id' => 'role_id',
		);
	}

	public function search() {
		$criteria=new CDbCriteria;
		$criteria->compare('action_id', $this->action_id);
		$criteria->compare('role_id', $this->role_id);
		$sort = new CSort();
		$sort->attributes = array('*');
		$sort->multiSort = true;
		return new CActiveDataProvider($this, array('criteria' => $criteria, 'sort' => $sort));
	}
	
}