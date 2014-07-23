<?php

class UserController extends MyController {
    public $layout = '//layouts/column2';
    public $defaultAction = 'admin';

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id)
        ));
    }

    public function actionCreate() {
        $model = new User();
        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->save()) $this->redirect(
                array(
                    'view',
                    'id' => $model->id
                ));
        }
        $this->render('create', array(
            'model' => $model
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->save()) $this->redirect(
                array(
                    'view',
                    'id' => $model->id
                ));
        }
        $this->render('update', array(
            'model' => $model
        ));
    }

    public function actionDelete($id) {
        $this->loadModel($id)->delete();
        if (! isset($_GET['ajax'])) $this->redirect(
            isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array(
                'admin'
            ));
    }

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('User');
        $this->render('index', array(
            'dataProvider' => $dataProvider
        ));
    }

    public function actionAdmin() {
        $model = new User('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['User'])) $model->attributes = $_GET['User'];
        $this->render('admin', array(
            'model' => $model
        ));
    }

    public function loadModel($id) {
        $model = User::model()->findByPk($id);
        if ($model === null) throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

}