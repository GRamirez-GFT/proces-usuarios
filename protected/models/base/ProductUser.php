<?php
/**
 * @property integer $user_id
 * @property integer $user_type_id
 */

class ProductUser extends MyActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'product_user';
	}

	public function rules() {
		return array(
		array('user_id, user_type_id', 'required'),
		array('user_id, user_type_id', 'numerical', 'integerOnly'=>true),
		array('user_id, user_type_id', 'safe', 'on' => 'search'),
		);
	}

	public function attributeLabels() {
		return array(
		'user_id' => 'user_id',
		'user_type_id' => 'user_type_id',
		);
	}

	public function search() {
		$criteria=new CDbCriteria;
		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('user_type_id', $this->user_type_id);
		$sort = new CSort();
		$sort->attributes = array('*');
		$sort->multiSort = true;
		return new CActiveDataProvider($this, array('criteria' => $criteria, 'sort' => $sort));
	}
	
}