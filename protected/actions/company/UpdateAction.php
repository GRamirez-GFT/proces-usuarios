<?php

class UpdateAction extends CAction {

    public function run($id = null) {
        $model = $this->controller->loadModel(Yii::app()->request->getParam('id', $id));
        $model->user->password = null;
        $prevUrl = $model->url_logo;

        if (Yii::app()->request->getPost(get_class($model))) {
            assignFile($file, $model, 'url_logo');
            $model->setAttributes(Yii::app()->request->getPost(get_class($model)));
            if ($file) {
                saveFile($file, $model, 'url_logo', $prevUrl);
            } else {
                $model->url_logo = $prevUrl;
            }
            if ($model->update()) {
                $this->controller->redirect(
                    array(
                        'view',
                        'id' => $model->id
                    ));
            }
        }
        $this->controller->render('update', array(
            'model' => $model
        ));
    }

}