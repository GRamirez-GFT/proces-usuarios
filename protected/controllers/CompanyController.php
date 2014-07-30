<?php

class CompanyController extends MyController {
    public $layout = '//layouts/column2';
    public $defaultAction = 'admin';

    public function loadModel($id) {
        $model = new CompanyModel();
        if ($model->load($id)) {return $model;}
        throw new CHttpException(404, 'The requested page does not exist.');
    }

    public function actions() {
        return array(
            'index' => 'application.actions.company.IndexAction',
            'view' => 'application.actions.company.ViewAction',
            'create' => 'application.actions.company.CreateAction',
            'update' => 'application.actions.company.UpdateAction',
            'delete' => 'application.actions.company.DeleteAction',
            'admin' => 'application.actions.company.AdminAction'
        );
    }


}