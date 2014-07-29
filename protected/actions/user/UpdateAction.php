<?php

class UpdateAction extends CAction {

    public function run($id = null) {
        $model = $this->controller->loadModel(Yii::app()->request->getParam('id', $id));
        $model->password = null;
        if (Yii::app()->request->getPost(get_class($model))) {
            $model->setAttributes(Yii::app()->request->getPost(get_class($model)));
            if ($model->update()) {
                $this->controller->redirect(
                    array(
                        'view',
                        'id' => $model->id
                    ));
            }
        }
        $this->controller->render('update', array(
            'model' => $model
        ));
    }

}