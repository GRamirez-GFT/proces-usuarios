<?php

class IndexAction extends CAction {

    public function run() {
        $dataProvider = new CActiveDataProvider('UserType');
        $this->controller->render('index', array(
            'dataProvider' => $dataProvider
        ));
    }

}