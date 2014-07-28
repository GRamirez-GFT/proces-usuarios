<?php

class IndexAction extends CAction {

    public function run() {
        $dataProvider = new CActiveDataProvider('Company');
        $this->controller->render('index', array(
            'dataProvider' => $dataProvider
        ));
    }

}