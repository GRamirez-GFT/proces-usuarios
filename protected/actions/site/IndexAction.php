<?php

class IndexAction extends CAction {

    public function run() {

        if (in_array(Yii::app()->user->role, array("general"))) {
            $this->controller->redirect(array(
                'user/view',
                'id' => Yii::app()->user->id
            ));
        } else if(in_array(Yii::app()->user->role, array("global"))) {
            Yii::app()->controller->redirect(array(
                'company/admin',
            ));
        }

        $this->controller->render('index');
    }

}