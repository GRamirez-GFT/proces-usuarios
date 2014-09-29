<?php

class CreateAction extends CAction {

    public function run() {
        $model = new CompanyModel();
        if (Yii::app()->request->getPost(get_class($model))) {
            assignFile($file, $model, 'url_logo');
            $model->setAttributes(Yii::app()->request->getPost(get_class($model)));
            if ($file) {
                saveFile($file, $model, 'url_logo');
            } else {
                $model->url_logo = $prevUrl;
            }
            if ($model->save()) {
                $this->controller->redirect(
                    array(
                        'view',
                        'id' => $model->id
                    ));
            }
        }
        $this->controller->render('create', array(
            'model' => $model
        ));
    }

}