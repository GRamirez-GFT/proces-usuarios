<?php

class LoginForm extends CFormModel {
    public $username;
    public $password;
    public $company;

    public function rules() {
        return array(
            array(
                'username, password',
                'required',
            ),
            array('company', 'length', 'max' => 30),
        );
    }

    public function attributeLabels() {
        return array(
            'username' => Yii::t('models/LoginForm', 'username'),
            'password' => Yii::t('models/LoginForm', 'password'),
            'company' => Yii::t('models/LoginForm', 'company')
        );
    }

}