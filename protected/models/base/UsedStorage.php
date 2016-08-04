<?php
/**
 * @property integer $company_id
 * @property string $ipv4
 *
 * @property Company $company
 */

class UsedStorage extends MyActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'used_storage';
	}

	public function rules() {
		return array(
		array('product_id, company_id, quantity', 'required'),
		array('product_id, company_id', 'numerical', 'integerOnly' => true),
		array('quantity', 'numerical'),
		array('product_id', 'exist', 'allowEmpty' => false, 'attributeName' => 'id', 'className' => 'Product'),
		array('company_id', 'exist', 'allowEmpty' => false, 'attributeName' => 'id', 'className' => 'Company'),
		array('product_id, company_id, quantity,', 'safe', 'on' => 'search'),
		);
	}

	public function relations() {
		return array(
		'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
		'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
		);
	}
	
	public function attributeLabels() {
		return array(
		'product_id' => Yii::t('models/UsedStorage', 'product_id'),
		'company_id' => Yii::t('models/UsedStorage', 'company_id'),
		'quantity' => Yii::t('models/UsedStorage', 'quantity'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;
		$criteria->compare('product_id', $this->product_id);
		$criteria->compare('company_id', $this->company_id);
		$criteria->compare('quantity', $this->quantity);
		$sort = new CSort();
		$sort->attributes = array('*');
		$sort->multiSort = true;
		return new CActiveDataProvider($this, array('criteria' => $criteria, 'sort' => $sort));
	}
	
}