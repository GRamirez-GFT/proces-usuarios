<?php
/**
 * @property integer $id
 * @property string $name
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $one_step_session_token
 * @property integer $company_id
 * @property boolean $active
 * @property string $date_create
 * @property integer $email_confirmed
 * @property string $email_confirm_token
 *
 * @property Company[] $companies
 * @property Product[] $products
 * @property Company $company
 * @property UserSession[] $userSessions
 */

class User extends MyActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'user';
	}

	public function rules() {
		return array(
		array('name, username, active, date_create', 'required'),
		array('active, email_confirmed', 'numerical', 'integerOnly' => true),
		array('name, email, email_confirm_token', 'length', 'max' => 100),
		array('one_step_session_token', 'length', 'max' => 300),
		array('username', 'length', 'max' => 32),
		array('password', 'length', 'max' => 72),
		array('company_id', 'exist', 'allowEmpty' => true, 'attributeName' => 'id', 'className' => 'Company'),
		array('id, name, username, password, email, company_id, active, date_create', 'safe', 'on' => 'search'),
		);
	}

	public function relations() {
		return array(
		'companies' => array(self::HAS_MANY, 'Company', 'user_id'),
		'products' => array(self::MANY_MANY, 'Product', 'product_user(user_id, product_id)'),
		'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
		);
	}
	
	public function attributeLabels() {
		return array(
		'id' => Yii::t('models/User', 'id'),
		'name' => Yii::t('models/User', 'name'),
		'username' => Yii::t('models/User', 'username'),
		'password' => Yii::t('models/User', 'password'),
		'email' => Yii::t('models/User', 'email'),
		'company_id' => Yii::t('models/User', 'company_id'),
		'active' => Yii::t('models/User', 'active'),
		'date_create' => Yii::t('models/User', 'date_create'),
		'email_confirmed' => Yii::t('models/User', 'email_confirmed'),
		'email_confirm_token' => Yii::t('models/User', 'email_confirm_token'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('username', $this->username, true);
		$criteria->compare('password', $this->password, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('company_id', $this->company_id);
		$criteria->compare('active', $this->active);
		$criteria->compare('date_create', $this->date_create);
		$criteria->compare('email_confirmed',$this->email_confirmed);
		$criteria->compare('email_confirm_token',$this->email_confirm_token,true);
		$sort = new CSort();
		$sort->attributes = array('*');
		$sort->multiSort = true;
		return new CActiveDataProvider($this, array('criteria' => $criteria, 'sort' => $sort));
	}
	
}