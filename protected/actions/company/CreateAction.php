<?php

class CreateAction extends CAction {

    public function run() {
        
        $model = new CompanyModel();
        $this->performAjaxValidation($model);
        $ajaxRequest = Yii::app()->request->getParam('ajaxRequest');

        $model->list_ips = array(0 => '');
        
        if (Yii::app()->request->getPost(get_class($model))) {
            
            $model->setAttributes(Yii::app()->request->getPost(get_class($model)));
            
            saveFile($model, 'url_logo', null, array('jpg', 'png', 'gif', 'jpeg'));
            
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