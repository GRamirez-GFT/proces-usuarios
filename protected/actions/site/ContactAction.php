<?php
class ContactAction extends CAction{

    public function run(){
        $model = new ContactForm();
        if (Yii::app()->request->isPostRequest) {
            $model->setAttributes(Yii::app()->request->getPost('ContactForm'));
            if ($model->validate()) {
                $this->controller->widget('application.widgets.mail.Mail',
                    array(
                        'view' => 'contact',
                        'params' => array(
                            'to' => array(
                                $model->email,
                                $model->name
                            ),
                            'cc' => array(
                                "rafaelt88@gmail.com", 'Rafael J Torres'
                            ),
                            'subject' => $model->subject
                        )
                    ));
                $this->controller->redirect(Yii::app()->homeUrl);
            }
        }
        $this->controller->render('contact', array(
            'model' => $model
        ));
    }
}