<?php

class UpdateAction extends CAction {

    public function run($id = null) {

        $model = $this->controller->loadModel(Yii::app()->request->getParam('id', $id));
        $this->performAjaxValidation($model);
        $ajaxRequest = Yii::app()->request->getParam('ajaxRequest');

        $model->password = null;
        if (Yii::app()->request->getPost(get_class($model))) {
            $postAttributes = array();
            if (in_array(Yii::app()->user->role, array("general"))) {
                foreach (Yii::app()->request->getPost(get_class($model)) as $attribute => $value) {
                    if(!in_array($attribute, array('name','email','password', 'verify_password'))) continue;

                    $postAttributes[$attribute] = $value;
                }
            } else {
                $postAttributes = Yii::app()->request->getPost(get_class($model));
            }

            $model->setAttributes($postAttributes);

            if(!isset($postAttributes['list_products']))
            {
                $model->list_products = array();
            }
            
            if($model->validate()) {

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
        if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}