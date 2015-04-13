<?php
/**
 * @property integer $user_id
 * @property integer $product_id
 * @property integer $is_used
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
		array('user_id, product_id, is_used', 'required'),
		array('user_id, product_id, is_used', 'numerical', 'integerOnly' => true),
        array('user_id', 'exist', 'allowEmpty' => false, 'attributeName' => 'id', 'className' => 'User'),
        array('product_id', 'exist', 'allowEmpty' => false, 'attributeName' => 'id', 'className' => 'Product'),
		array('user_id, product_id, is_used', 'safe', 'on' => 'search'),
		);
	}

	public function relations() {
		return array(
		'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
		);
	}
    
	public function attributeLabels() {
		return array(
		'user_id' => Yii::t('models/ProductUser', 'user_id'),
		'product_id' => Yii::t('models/ProductUser', 'product_id'),
        'is_used' => Yii::t('models/ProductUser', 'is_used'),
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