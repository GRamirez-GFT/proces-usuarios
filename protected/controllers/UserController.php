<?php

class UserController extends MyController {

    public function actionIndex() {
        $model = new User();
        $this->render('index', array(
            'model' => $model
        ));
    }

    public function actionCreate() {
        $model = new User();
        if (Yii::app()->request->getPost('User')) {
            $model->setAttributes(Yii::app()->request->getPost('User'));
            $model->date_create = date('Y-m-d');
            if ($model->save()) {
                $this->redirect(array(
                    'index'
                ));
            }
        }
        $this->render('create', array(
            'model' => $model
        ));
    }

    public function actionView($id) {
        $model = $this->loadModel($id);
        $this->render('view', array(
            'model' => $model
        ));
    }
    
    public function loadModel($id) {
        $model = User::model()->findByPk($id);
        if ($model === null) throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

}
