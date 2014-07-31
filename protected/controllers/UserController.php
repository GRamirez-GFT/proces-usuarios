<?php

class UserController extends MyController {
    public $layout = '//layouts/column2';
    public $defaultAction = 'admin';

    public function init() {
        parent::init();
        if (Yii::app()->user->role == 'general') {
            $this->defaultAction = 'view';
        }
    }

    public function loadModel($id) {
        $model = new UserModel();
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
                    'expression' => 'in_array(Yii::app()->user->role, array("company"))'
                ),
                array(
                    'allow',
                    'actions' => array(
                        'view', 'update'
                    ),
                    'users' => array(
                        '@'
                    ),
                    'expression' => 'in_array(Yii::app()->user->role, array("general"))'
                )
            ), parent::accessRules());
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