<?php

class UserController extends MyController {

    public function init() {
        parent::init();
        if(!Yii::app()->user->isGuest) {
            if (Yii::app()->user->role == 'general') {
                $this->defaultAction = 'view';
            }
        }
    }

    public function loadModel($id) {
        if ($model = UserModel::model()->findByPk($id)) {return $model;}
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
                        'view', 'update', 'activate'
                    ),
                    'users' => array(
                        '@'
                    ),
                    'expression' => 'in_array(Yii::app()->user->role, array("company","general"))'
                ),
                array(
                    'allow',
                    'actions' => array('verifyEmail'),
                    'users' => array(
                        '*'
                    ),
                ),
            ), parent::accessRules());
    }

    public function actions() {
        return array(
            'view' => 'application.actions.user.ViewAction',
            'activate' => 'application.actions.user.ActivateAction',
            'create' => 'application.actions.user.CreateAction',
            'update' => 'application.actions.user.UpdateAction',
            'delete' => 'application.actions.user.DeleteAction',
            'admin' => 'application.actions.user.AdminAction',
            'verifyEmail' => 'application.actions.user.VerifyEmailAction',
        );
    }

}