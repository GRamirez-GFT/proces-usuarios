<?php

class UpdateAction extends CAction {

    public function run($id = null) {
        $model = $this->controller->loadModel(Yii::app()->request->getParam('id', $id));
        $this->performAjaxValidation($model);
        $ajaxRequest = Yii::app()->request->getParam('ajaxRequest');

        if (Yii::app()->request->getPost(get_class($model))) {
            $model->setAttributes(Yii::app()->request->getPost(get_class($model)));
            if ($model->update()) {
                $redirectParms = array(
                        'view',
                        'id' => $model->id
                );

                if($ajaxRequest) {
                    $redirectParms['ajaxRequest'] = true;
                } 
                
                $this->controller->redirect($redirectParms);
            }
        }

        if($ajaxRequest) {
            $this->controller->renderPartial('update', array(
                'model' => $model,
                'ajaxRequest' => true,
            ), false, true);
        } else {
            $this->controller->render('update', array(
                'model' => $model
            ));
        }
    }

    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='product-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}