<?php
/**
 * @property integer $id
 * @property string $name
 * @property integer $company_id
 * @property integer $product_id
 *
 * @property Action[] $actions
 * @property Product $product
 * @property Company $company
 * @property User[] $users
 */

class Role extends MyActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'role';
	}

	public function rules() {
		return array(
		array('name, company_id, product_id', 'required'),
		array('company_id, product_id', 'numerical', 'integerOnly' => true),
		array('name', 'length', 'max' => 50),
		array('product_id', 'exist', 'allowEmpty' => true, 'attributeName' => 'id', 'className' => 'Product'),
		array('company_id', 'exist', 'allowEmpty' => true, 'attributeName' => 'id', 'className' => 'Company'),
		array('id, name, company_id, product_id', 'safe', 'on' => 'search'),
		);
	}

	public function relations() {
		return array(
		'actions' => array(self::MANY_MANY, 'Action', 'action_role(role_id, action_id)'),
		'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
		'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
		'users' => array(self::MANY_MANY, 'User', 'user_role(role_id, user_id)'),
		);
	}
	
	public function attributeLabels() {
		return array(
		'id' => 'id',
		'name' => 'name',
		'company_id' => 'company_id',
		'product_id' => 'product_id',
		);
	}

	public function search() {
		$criteria=new CDbCriteria;
		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('company_id', $this->company_id);
		$criteria->compare('product_id', $this->product_id);
		$sort = new CSort();
		$sort->attributes = array('*');
		$sort->multiSort = true;
		return new CActiveDataProvider($this, array('criteria' => $criteria, 'sort' => $sort));
	}
	
}