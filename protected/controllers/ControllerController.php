<?php

class ControllerController extends MyController {
    public $layout = '//layouts/column2';
    public $defaultAction = 'admin';

    public function loadModel($id) {
        $model = new ControllerModel();
        if ($model->load($id)) {return $model;}
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
                )
            ), parent::accessRules());
    }

    public function actions() {
        return array(
            'index' => 'application.actions.controller.IndexAction',
            'view' => 'application.actions.controller.ViewAction',
            'create' => 'application.actions.controller.CreateAction',
            'update' => 'application.actions.controller.UpdateAction',
            'delete' => 'application.actions.controller.DeleteAction',
            'admin' => 'application.actions.controller.AdminAction'
        );
    }

}