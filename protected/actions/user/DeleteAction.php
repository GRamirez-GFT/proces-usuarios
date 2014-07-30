<?php

class DeleteAction extends CAction {

    public function run($id = null) {
        try {
            $model = $this->controller->loadModel(Yii::app()->request->getParam('id', $id));
            if ($model->delete()) {
                $this->controller->redirect(array(
                    'index'
                ));
            }
        } catch (Exception $e) {
            throw new CHttpException(400, Yii::t('yii', 'Your request is invalid.'));
        }
    }

}