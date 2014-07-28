<?php

class AdminAction extends CAction {

    public function run() {
        $model = new UserModel('search');
        $model->setAttributes(Yii::app()->request->getParam(get_class($model)));
        $this->controller->render('admin', array(
            'model' => $model
        ));
    }

}