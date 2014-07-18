<?php

class LoginAction extends CAction {

    public function run() {
        if (! Yii::app()->user->isGuest) {
            $this->controller->redirect(Yii::app()->homeUrl);
        }
        $model = new LoginForm();
        if (Yii::app()->request->getPost('LoginForm')) {
            $model->setAttributes(Yii::app()->request->getPost('LoginForm'));
            if ($model->validate()) {
                $this->controller->redirect(Yii::app()->homeUrl);
            }
        }
        $this->controller->render('login', array(
            'model' => $model
        ));
    }

}