<?php

class DeleteAction extends CAction {

    public function run($id = null) {

        $model = $this->controller->loadModel(Yii::app()->request->getParam('id', $id));
        
        if($model->id != $model->company->user_id) {
            if ($model->delete()) {
                $this->controller->redirect(array(
                    'admin'
                ));
            }
        }
        
        throw new CHttpException(400, Yii::t('yii', 'Your request is invalid.'));

    }

}