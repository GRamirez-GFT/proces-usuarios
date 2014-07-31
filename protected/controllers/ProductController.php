<?php

class ProductController extends MyController {
    public $layout = '//layouts/column2';
    public $defaultAction = 'admin';

    public function loadModel($id) {
        $model = new ProductModel();
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
                ),
            ), parent::accessRules());
    }


    public function actions() {
        return array(
            'index' => 'application.actions.product.IndexAction',
            'view' => 'application.actions.product.ViewAction',
            'create' => 'application.actions.product.CreateAction',
            'update' => 'application.actions.product.UpdateAction',
            'delete' => 'application.actions.product.DeleteAction',
            'admin' => 'application.actions.product.AdminAction'
        );
    }


}