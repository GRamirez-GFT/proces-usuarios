<?php

class ControllerController extends MyController {
    public $layout = '//layouts/column2';
    public $defaultAction = 'admin';

    public function loadModel($id) {
        $model = new ControllerModel();
        if ($model->load($id)) {return $model;}
        throw new CHttpException(404, 'The requested page does not exist.');
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