<?php

class IndexAction extends CAction {

    public function run() {

        switch(Yii::app()->user->role) {
            case "general":
                $this->controller->redirect(array(
                    'user/view',
                    'id' => Yii::app()->user->id
                ));
                break;
            case "company":
                Yii::app()->controller->redirect(array(
                    'user/admin',
                ));
                break;
            case "global":
                Yii::app()->controller->redirect(array(
                    'company/admin',
                ));
                break;
            
            default:
                $this->controller->redirect(array(
                    'user/view',
                    'id' => Yii::app()->user->id
                ));
                break;
        }

        $this->controller->render('index');
    }

}