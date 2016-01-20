<?php
/**
 * @property integer $company_id
 * @property string $ipv4
 *
 * @property Company $company
 */

class AllowedIp extends MyActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'allowed_ip';
	}

	public function rules() {
		return array(
		array('company_id, ipv4', 'required'),
		array('company_id', 'numerical', 'integerOnly' => true),
		array('ipv4', 'length', 'max' => 45),
		array('company_id', 'exist', 'allowEmpty' => false, 'attributeName' => 'id', 'className' => 'Company'),
		array('company_id, ipv4', 'safe', 'on' => 'search'),
		);
	}

	public function relations() {
		return array(
		'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
		);
	}
	
	public function attributeLabels() {
		return array(
		'company_id' => Yii::t('models/AllowedIp', 'company_id'),
		'ipv4' => Yii::t('models/AllowedIp', 'ipv4'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;
		$criteria->compare('company_id', $this->company_id);
		$criteria->compare('ipv4', $this->ipv4);
		$sort = new CSort();
		$sort->attributes = array('*');
		$sort->multiSort = true;
		return new CActiveDataProvider($this, array('criteria' => $criteria, 'sort' => $sort));
	}
	
}