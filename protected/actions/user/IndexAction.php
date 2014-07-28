<?php

class IndexAction extends CAction {

    public function run() {
        $dataProvider = new CActiveDataProvider('User');
        $this->controller->render('index', array(
            'dataProvider' => $dataProvider
        ));
    }

}