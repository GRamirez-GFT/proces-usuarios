<?php

class ViewAction extends CAction {

    public function run($id = null) {
        $model = $this->controller->loadModel(Yii::app()->request->getParam('id', $id));

        if(Yii::app()->request->getParam('ajaxRequest')) {
	        $this->controller->renderPartial('view', array(
	            'model' => $model,
	            'ajaxRequest' => true,
	        ));
        } else {
	        $this->controller->render('view', array(
	            'model' => $model
	        ));
        }
    }

}