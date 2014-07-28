<?php

class IndexAction extends CAction {

    public function run() {
        $dataProvider = new CActiveDataProvider('Role');
        $this->controller->render('index', array(
            'dataProvider' => $dataProvider
        ));
    }

}