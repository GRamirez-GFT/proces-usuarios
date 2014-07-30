<?php

class ViewAction extends CAction {

    public function run($id = null) {
        $model = $this->controller->loadModel(Yii::app()->request->getParam('id', $id));
        $this->controller->render('view', array(
            'model' => $model
        ));
    }

}