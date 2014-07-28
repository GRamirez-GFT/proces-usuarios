<?php

class RoleController extends MyController {
    public $layout = '//layouts/column2';
    public $defaultAction = 'admin';

    public function loadModel() {
        $model = new RoleModel();
        if ($model->load(Yii::app()->request->getParam('id'))) {return $model;}
        throw new CHttpException(404, 'The requested page does not exist.');
    }

    public function actions() {
        return array(
            'index' => 'application.actions.role.IndexAction',
            'view' => 'application.actions.role.ViewAction',
            'create' => 'application.actions.role.CreateAction',
            'update' => 'application.actions.role.UpdateAction',
            'delete' => 'application.actions.role.DeleteAction',
            'admin' => 'application.actions.role.AdminAction'
        );
    }

}