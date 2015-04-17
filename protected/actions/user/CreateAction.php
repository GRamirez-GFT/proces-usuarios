<?php

class CreateAction extends CAction {

    public function run() {

        $model = new UserModel();
        $this->performAjaxValidation($model);
        $ajaxRequest = Yii::app()->request->getParam('ajaxRequest');

        if (Yii::app()->request->getPost(get_class($model))) {
            $model->setAttributes(Yii::app()->request->getPost(get_class($model)));
            if ($model->save()) {
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
            $this->controller->renderPartial('create', array(
                'model' => $model,
                'ajaxRequest' => true,
            ), false, true);
        } else {
            $this->controller->render('create', array(
                'model' => $model
            ));
        }
        
    }

    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}