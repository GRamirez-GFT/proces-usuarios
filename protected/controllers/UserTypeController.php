<?php

class UserTypeController extends MyController {
    public $layout = '//layouts/column2';
    public $defaultAction = 'admin';

    public function loadModel() {
        $model = new UserTypeModel();
        if ($model->load(Yii::app()->request->getParam('id'))) {return $model;}
        throw new CHttpException(404, 'The requested page does not exist.');
    }

    public function actions() {
        return array(
            'index' => 'application.actions.usertype.IndexAction',
            'view' => 'application.actions.usertype.ViewAction',
            'create' => 'application.actions.usertype.CreateAction',
            'update' => 'application.actions.usertype.UpdateAction',
            'delete' => 'application.actions.usertype.DeleteAction',
            'admin' => 'application.actions.usertype.AdminAction'
        );
    }


}