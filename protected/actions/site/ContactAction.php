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
                                "contacto@iconoconsultoria.com", 'Icono Consultoria'
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