<?php

class LoginForm extends CFormModel {
    public $username;
    public $password;
    public $company;

    public function rules() {
        return array(
            array(
                'username, password, company',
                'required'
            )
        );
    }

    public function attributeLabels() {
        return array(
            'username' => Yii::t('model/LoginForm', 'username'),
            'password' => Yii::t('model/LoginForm', 'password'),
            'company' => Yii::t('model/LoginForm', 'company')
        );
    }

}