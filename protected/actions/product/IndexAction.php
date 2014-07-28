<?php

class IndexAction extends CAction {

    public function run() {
        $dataProvider = new CActiveDataProvider('Product');
        $this->controller->render('index', array(
            'dataProvider' => $dataProvider
        ));
    }

}