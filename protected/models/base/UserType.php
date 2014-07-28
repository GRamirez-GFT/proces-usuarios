<?php
/**
 * @property integer $id
 * @property integer $product_id
 * @property string $name
 *
 * @property User[] $users
 * @property Product $product
 */

class UserType extends MyActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'user_type';
	}

	public function rules() {
		return array(
		array('product_id, name', 'required'),
		array('product_id', 'numerical', 'integerOnly'=>true),
		array('name', 'length', 'max'=>100),
		array('product_id', 'exist', 'allowEmpty' => true, 'attributeName' => 'id', 'className' => 'Product'),
		array('id, product_id, name', 'safe', 'on' => 'search'),
		);
	}

	public function relations() {
		return array(
		'users' => array(self::MANY_MANY, 'User', 'product_user(user_type_id, user_id)'),
		'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
		);
	}
	
	public function attributeLabels() {
		return array(
		'id' => 'id',
		'product_id' => 'product_id',
		'name' => 'name',
		);
	}

	public function search() {
		$criteria=new CDbCriteria;
		$criteria->compare('id', $this->id);
		$criteria->compare('product_id', $this->product_id);
		$criteria->compare('name', $this->name, true);
		$sort = new CSort();
		$sort->attributes = array('*');
		$sort->multiSort = true;
		return new CActiveDataProvider($this, array('criteria' => $criteria, 'sort' => $sort));
	}
	
}