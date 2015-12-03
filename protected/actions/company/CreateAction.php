<?php

class CreateAction extends CAction {

    public function run() {
        
        $model = new CompanyModel();
        $this->performAjaxValidation($model);
        $ajaxRequest = Yii::app()->request->getParam('ajaxRequest');

        $model->list_ips = array(0 => '');
        
        if (Yii::app()->request->getPost(get_class($model))) {
            
            assignFile($file, $model, 'url_logo');
            
            $model->setAttributes(Yii::app()->request->getPost(get_class($model)));
            
            if ($file) {
                saveFile($file, $model, 'url_logo');
            }
            
            if ($model->save()) {
                $redirectParms = array(
                        'view',
                        'id' => $model->id
                );

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
        if(isset($_POST['ajax']) && $_POST['ajax']==='company-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}