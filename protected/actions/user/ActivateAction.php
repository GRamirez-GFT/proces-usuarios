<?php

class ActivateAction extends CAction {

    public function run($id = null) {

        $model = $this->controller->loadModel(Yii::app()->request->getParam('id', $id));
        
        if($model->id != $model->company->user_id) {
        	if($model->active) {
        		$model->active = 0;
        	} else {

        		$activeUsers = User::model()->findAllByAttributes(array(
        			'active' => '1', 
        			'company_id' => $model->company_id
        		), "id != {$model->company->user_id}");

        		if(count($activeUsers) >= $model->company->licenses) {
        			throw new CHttpException(400, Yii::t('base', 'The company has reached the maximum of active licenses.'));
        		}

    			$model->active = 1;
        	}

            if ($model->update(array('active'))) {
                $this->controller->redirect(array(
                    'admin'
                ));
            }
        }
        
        throw new CHttpException(400, Yii::t('yii', 'Your request is invalid.'));

    }

}