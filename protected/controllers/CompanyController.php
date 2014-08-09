<?php

class CompanyController extends MyController {
    public $layout = '//layouts/column2';
    public $defaultAction = 'admin';

    public function loadModel($id) {
        if ($model = CompanyModel::model()->findByPk($id)) {return $model;}
        throw new CHttpException(404, 'The requested page does not exist.');
    }

    public function accessRules() {
        return CMap::mergeArray(
            array(
                array(
                    'allow',
                    'actions' => array(),
                    'users' => array(
                        '@'
                    ),
                    'expression' => 'in_array(Yii::app()->user->role, array("global"))'
                ),
            ), parent::accessRules());
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