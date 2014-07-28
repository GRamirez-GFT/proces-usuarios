<?php

class UserController extends MyController {
    public $layout = '//layouts/column2';
    public $defaultAction = 'admin';

    public function loadModel() {
        $model = new UserModel();
        if ($model->load(Yii::app()->request->getParam('id'))) {return $model;}
        throw new CHttpException(404, 'The requested page does not exist.');
    }

    public function actions() {
        return array(
            'index' => 'application.actions.user.IndexAction',
            'view' => 'application.actions.user.ViewAction',
            'create' => 'application.actions.user.CreateAction',
            'update' => 'application.actions.user.UpdateAction',
            'delete' => 'application.actions.user.DeleteAction',
            'admin' => 'application.actions.user.AdminAction'
        );
    }

}