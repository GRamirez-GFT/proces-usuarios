<?php

class DeleteAction extends CAction {

    public function run() {
        try {
            $model = $this->controller->loadModel();
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