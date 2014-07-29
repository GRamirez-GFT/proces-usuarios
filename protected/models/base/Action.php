<?php
/**
 * @property integer $id
 * @property string $name
 * @property integer $controller_id
 *
 * @property Controller $controller
 * @property User[] $users
 */

class Action extends MyActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'action';
	}

	public function rules() {
		return array(
		array('name, controller_id', 'required'),
		array('controller_id', 'numerical', 'integerOnly' => true),
		array('name', 'length', 'max' => 100),
		array('controller_id', 'exist', 'allowEmpty' => true, 'attributeName' => 'id', 'className' => 'Controller'),
		array('id, name, controller_id', 'safe', 'on' => 'search'),
		);
	}

	public function relations() {
		return array(
		'controller' => array(self::BELONGS_TO, 'Controller', 'controller_id'),
		'users' => array(self::MANY_MANY, 'User', 'action_user(action_id, user_id)'),
		);
	}
	
	public function attributeLabels() {
		return array(
		'id' => 'id',
		'name' => 'name',
		'controller_id' => 'controller_id',
		);
	}

	public function search() {
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('controller_id', $this->controller_id);
		$sort = new CSort();
		$sort->attributes = array('*');
		$sort->multiSort = true;
		return new CActiveDataProvider($this, array('criteria' => $criteria, 'sort' => $sort));
	}
	
}