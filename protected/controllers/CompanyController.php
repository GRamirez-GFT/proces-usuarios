<?php

class CompanyController extends MyController {

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
                array(
                    'allow',
                    'actions' => array('view'),
                    'users' => array(
                        '@'
                    ),
                    'expression' => 'in_array(Yii::app()->user->role, array("company", "global"))'
                ),
                array(
                    'allow',
                    'actions' => array('update'),
                    'users' => array(
                        '@'
                    ),
                    'expression' => 'in_array(Yii::app()->user->role, array("global")) || (in_array(Yii::app()->user->role, array("company")) && Yii::app()->request->getParam("id") == Yii::app()->user->company_id)'
                ),
            ), parent::accessRules());
    }

    public function actions() {
        return array(
            'view' => 'application.actions.company.ViewAction',
            'create' => 'application.actions.company.CreateAction',
            'update' => 'application.actions.company.UpdateAction',
            'delete' => 'application.actions.company.DeleteAction',
            'admin' => 'application.actions.company.AdminAction'
        );
    }

}