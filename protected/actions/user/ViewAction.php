<?php

class ViewAction extends CAction {

    public function run($id = null) {
        if (Yii::app()->user->role == 'general') {
            $model = $this->controller->loadModel(Yii::app()->user->id);
        } else {
            $model = $this->controller->loadModel(Yii::app()->request->getParam('id', $id));
        }
        $this->controller->render('view', array(
            'model' => $model
        ));
    }

}