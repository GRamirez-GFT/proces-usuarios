<?php

class IndexAction extends CAction {

    public function run() {
        $dataProvider = new CActiveDataProvider('Product');
        if (isset(Yii::app()->user->company_id)) {
            $dataProvider->criteria->condition = 'company_id="' . Yii::app()->user->company_id . '"';
        } else {
            $dataProvider->criteria->condition = 'company_id IS NULL';
        }
        $this->controller->render('index', array(
            'dataProvider' => $dataProvider
        ));
    }

}