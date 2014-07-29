<?php
/**
 * @property integer $id
 * @property string $name
 * @property string $url_controller
 * @property integer $product_id
 *
 * @property Action[] $actions
 * @property Product $product
 */

class Controller extends MyActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'controller';
	}

	public function rules() {
		return array(
		array('name, product_id', 'required'),
		array('product_id', 'numerical', 'integerOnly' => true),
		array('name', 'length', 'max' => 100),
		array('url_controller', 'length', 'max' => 255),
		array('product_id', 'exist', 'allowEmpty' => true, 'attributeName' => 'id', 'className' => 'Product'),
		array('id, name, url_controller, product_id', 'safe', 'on' => 'search'),
		);
	}

	public function relations() {
		return array(
		'actions' => array(self::HAS_MANY, 'Action', 'controller_id'),
		'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
		);
	}
	
	public function attributeLabels() {
		return array(
		'id' => 'id',
		'name' => 'name',
		'url_controller' => 'url_controller',
		'product_id' => 'product_id',
		);
	}

	public function search() {
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('url_controller', $this->url_controller, true);
		$criteria->compare('product_id', $this->product_id);
		$sort = new CSort();
		$sort->attributes = array('*');
		$sort->multiSort = true;
		return new CActiveDataProvider($this, array('criteria' => $criteria, 'sort' => $sort));
	}
	
}