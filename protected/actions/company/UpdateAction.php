<?php

class UpdateAction extends CAction {

    public function run($id = null) {
        $model = $this->controller->loadModel(Yii::app()->request->getParam('id', $id));
        $this->performAjaxValidation($model);
        $ajaxRequest = Yii::app()->request->getParam('ajaxRequest');

        $model->user->password = null;
        $prevUrl = $model->url_logo;
        $prevSubdomain = $model->subdomain;
        $prevListProducts = $model->list_products;
        
        if(empty($model->list_ips)) {
            $model->list_ips = array(0 => '');
        }

        if (Yii::app()->request->getPost(get_class($model))) {
            
            $model->list_products = array();
            assignFile($file, $model, 'url_logo');
            $model->setAttributes(Yii::app()->request->getPost(get_class($model)));
            if ($file) {
                saveFile($file, $model, 'url_logo', $prevUrl);
            } else {
                $model->url_logo = $prevUrl;
            }

            if(in_array(Yii::app()->user->role, array("company"))){
                $model->setAttribute('subdomain',$prevSubdomain);
                $model->setAttribute('list_products',$prevListProducts);
            }

            if ($model->update()) {
                $redirectParms = array(
                        'view',
                        'id' => $model->id
                );
                
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='company-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}