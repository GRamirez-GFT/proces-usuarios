<?php

class LoginForm extends CFormModel {
    public $username;
    public $password;
    private $_identity;

    public function rules() {
        return array(
            array(
                'username, password',
                'required'
            ),
            array(
                'username',
                'filter',
                'filter' => 'strtolower'
            ),
            array(
                'username',
                'active'
            ),
            array(
                'password',
                'authenticate'
            )
        );
    }

    public function attributeLabels() {
        return array(
            'username' => Yii::t('model/LoginForm', 'username'),
            'password' => Yii::t('model/LoginForm', 'password')
        );
    }

    public function active($attribute_name, $params) {
        if (User::model()->exists("username='{$this->username}' AND active<>1")) {
            $this->addError($attribute_name, Yii::t('model/LoginForm', 'user inactive'));
        }
    }

    public function authenticate() {
        if (Yii::app()->user->start($this->username, $this->password)) {
            return Yii::app()->user->login(new CUserIdentity($this->username, $this->password));
        } else {
            $this->addError('password', Yii::t('model/LoginForm', 'fail authenticate'));
        }
    }

}