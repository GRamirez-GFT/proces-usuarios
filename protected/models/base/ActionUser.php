<?php
/**
 * @property integer $action_id
 * @property integer $user_id
 */

class ActionUser extends MyActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'action_user';
	}

	public function rules() {
		return array(
		array('action_id, user_id', 'required'),
		array('action_id, user_id', 'numerical', 'integerOnly' => true),
		array('action_id, user_id', 'safe', 'on' => 'search'),
		);
	}

	public function attributeLabels() {
		return array(
		'action_id' => 'action_id',
		'user_id' => 'user_id',
		);
	}

	public function search() {
		$criteria = new CDbCriteria;
		$criteria->compare('action_id', $this->action_id);
		$criteria->compare('user_id', $this->user_id);
		$sort = new CSort();
		$sort->attributes = array('*');
		$sort->multiSort = true;
		return new CActiveDataProvider($this, array('criteria' => $criteria, 'sort' => $sort));
	}
	
}