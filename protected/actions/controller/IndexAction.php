<?php

class IndexAction extends CAction {

    public function run() {
        $dataProvider = new CActiveDataProvider('Controller');
        $this->controller->render('index', array(
            'dataProvider' => $dataProvider
        ));
    }

}