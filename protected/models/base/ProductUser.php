<?php
/**
 * @property integer $user_id
 * @property integer $product_id
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
		array('user_id, product_id', 'required'),
		array('user_id, product_id', 'numerical', 'integerOnly' => true),
		array('user_id, product_id', 'safe', 'on' => 'search'),
		);
	}

	public function attributeLabels() {
		return array(
		'user_id' => Yii::t('models/ProductUser', 'user_id'),
		'product_id' => Yii::t('models/ProductUser', 'product_id'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;
		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('product_id', $this->product_id);
		$sort = new CSort();
		$sort->attributes = array('*');
		$sort->multiSort = true;
		return new CActiveDataProvider($this, array('criteria' => $criteria, 'sort' => $sort));
	}
	
}