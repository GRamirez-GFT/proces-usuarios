<?php

class IndexAction extends CAction {

    public function run() {
        $dataProvider = new CActiveDataProvider('Product');
        if (in_array(Yii::app()->user->role, array("company"))) {
            $dataProvider->criteria->condition = 'company_id="' . Yii::app()->user->company_id . '"';
        }
        $this->controller->render('index', array(
            'dataProvider' => $dataProvider
        ));
    }

}