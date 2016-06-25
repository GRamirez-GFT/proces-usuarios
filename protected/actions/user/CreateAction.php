<?php

class CreateAction extends CAction {

    public function run() {

        $model = new UserModel();
        $this->performAjaxValidation($model);
        $ajaxRequest = Yii::app()->request->getParam('ajaxRequest');

        /*
        * Validate licenses
        */
        $company = Company::model()->findByPk(Yii::app()->user->company_id);
        $activeUsers = User::model()->findAllByAttributes(array(
            'active' => '1', 
            'company_id' => Yii::app()->user->company_id
        ), "id != {$company->user_id}");

        if(count($activeUsers) >= $company->licenses) {
            throw new CHttpException(400, Yii::t('base', 'The company has reached the maximum of active licenses.'));
        }

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