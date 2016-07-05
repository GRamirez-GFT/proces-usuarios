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
        $prevLicenses = $model->licenses;
        $changedLogo = true;
        
        if(empty($model->list_ips)) {
            $model->list_ips = array(0 => '');
        }

        if (Yii::app()->request->getPost(get_class($model))) {
            
            $model->list_products = array();
            $model->setAttributes(Yii::app()->request->getPost(get_class($model)));

            if(!saveFile($model, 'url_logo', null, array('jpg', 'png', 'gif', 'jpeg'))) {
                $changedLogo = false;
                $model->url_logo = $prevUrl;
            }

            if(in_array(Yii::app()->user->role, array("company"))){
                $model->setAttribute('licenses',$prevLicenses);
                $model->setAttribute('subdomain',$prevSubdomain);
                $model->setAttribute('list_products',$prevListProducts);
            }
            
            if ($model->update()) {

                if($changedLogo) {
                    removeFile($prevUrl);
                }

                $redirectParms = array(
                        'view',
                        'id' => $model->id
                );
                
                $this->controller->redirect($redirectParms);
            } else {
                if($changedLogo) {
                    removeFile($model->url_logo);
                }
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