<?php

class CompanyController extends MyController {
    public $layout = '//layouts/column2';

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id)
        ));
    }

    public function actionCreate() {
        $model = new Company();
        if (isset($_POST['Company'])) {
            $model->attributes = $_POST['Company'];
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
        if (isset($_POST['Company'])) {
            $model->attributes = $_POST['Company'];
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
        $dataProvider = new CActiveDataProvider('Company');
        $this->render('index', array(
            'dataProvider' => $dataProvider
        ));
    }

    public function actionAdmin() {
        $model = new Company('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Company'])) $model->attributes = $_GET['Company'];
        $this->render('admin', array(
            'model' => $model
        ));
    }

    public function loadModel($id) {
        $model = Company::model()->findByPk($id);
        if ($model === null) throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

}