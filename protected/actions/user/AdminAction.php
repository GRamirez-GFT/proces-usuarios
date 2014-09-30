<?php

class AdminAction extends CAction {

    public function run() {

        if (in_array(Yii::app()->user->role, array("general"))) {
            $this->controller->redirect(array(
                'user/view',
                'id' => Yii::app()->user->id
            ));
        }

        $model = new UserModel('search');
        $model->setAttributes(Yii::app()->request->getParam(get_class($model)));
        $this->controller->render('admin', array(
            'model' => $model
        ));
    }

}