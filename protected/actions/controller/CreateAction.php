<?php

class CreateAction extends CAction {

    public function run() {
        $model = new ControllerModel();
        if (Yii::app()->request->getPost(get_class($model))) {
            $model->setAttributes(Yii::app()->request->getPost(get_class($model)));
            if ($model->save()) {
                $this->controller->redirect(
                    array(
                        'view',
                        'id' => $model->id
                    ));
            }
        }
        $this->controller->render('create', array(
            'model' => $model
        ));
    }

}