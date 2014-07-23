<?php
/**
 * @property integer $id
 * @property string $session
 * @property string $ipv4
 * @property string $time_login
 * @property string $time_logout
 * @property integer $user_id
 *
 * @property User $user
 */

class UserSession extends MyActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'user_session';
	}

	public function rules() {
		return array(
		array('session, ipv4, time_login, user_id', 'required'),
		array('user_id', 'numerical', 'integerOnly'=>true),
		array('session', 'length', 'max'=>32),
		array('ipv4', 'length', 'max'=>15),
		array('time_logout', 'safe'),
		array('user_id', 'exist', 'allowEmpty' => true, 'attributeName' => 'id', 'className' => 'User'),
		array('id, session, ipv4, time_login, time_logout, user_id', 'safe', 'on' => 'search'),
		);
	}

	public function relations() {
		return array(
		'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}
	
	public function attributeLabels() {
		return array(
		'id' => 'id',
		'session' => 'session',
		'ipv4' => 'ipv4',
		'time_login' => 'time_login',
		'time_logout' => 'time_logout',
		'user_id' => 'user_id',
		);
	}

	public function search() {
		$criteria=new CDbCriteria;
		$criteria->compare('id', $this->id);
		$criteria->compare('session', $this->session, true);
		$criteria->compare('ipv4', $this->ipv4, true);
		$criteria->compare('time_login', $this->time_login);
		$criteria->compare('time_logout', $this->time_logout);
		$criteria->compare('user_id', $this->user_id);
		$sort = new CSort();
		$sort->attributes = array('*');
		$sort->multiSort = true;
		return new CActiveDataProvider($this, array('criteria' => $criteria, 'sort' => $sort));
	}
	
}