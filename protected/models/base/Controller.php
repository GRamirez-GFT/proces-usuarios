<?php
/**
 * @property integer $id
 * @property string $name
 * @property integer $module_id
 *
 * @property Action[] $actions
 * @property Module $module
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
		array('name, module_id', 'required'),
		array('module_id', 'numerical', 'integerOnly' => true),
		array('name', 'length', 'max' => 100),
		array('module_id', 'exist', 'allowEmpty' => true, 'attributeName' => 'id', 'className' => 'Module'),
		array('id, name, module_id', 'safe', 'on' => 'search'),
		);
	}

	public function relations() {
		return array(
		'actions' => array(self::HAS_MANY, 'Action', 'controller_id'),
		'module' => array(self::BELONGS_TO, 'Module', 'module_id'),
		);
	}
	
	public function attributeLabels() {
		return array(
		'id' => 'id',
		'name' => 'name',
		'module_id' => 'module_id',
		);
	}

	public function search() {
		$criteria=new CDbCriteria;
		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('module_id', $this->module_id);
		$sort = new CSort();
		$sort->attributes = array('*');
		$sort->multiSort = true;
		return new CActiveDataProvider($this, array('criteria' => $criteria, 'sort' => $sort));
	}
	
}