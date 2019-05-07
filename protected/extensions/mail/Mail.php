<?php
/**
 *
 * @company Jorge Gonzalez <gonzalez_fx@hotmail.com>
 */
require_once Yii::getPathOfAlias('webroot.vendor.phpmailer.phpmailer') . '/PHPMailerAutoload.php';

class Mail extends CWidget {
    public $mail;
    public $view;
    public $params;

    public function init() {
        $this->mail = new PHPMailer();
        $this->mail->Host = 'email-smtp.us-west-2.amazonaws.com';
        $this->mail->Username = 'AKIAIMHEVQZQKTPSYCHA';
        $this->mail->Password = 'AhA4zZuFa5ozynT05RzjqHXi7r7VJ6LZ4/0ED894bmi/';
        $this->mail->Mailer = 'smtp';
        $this->mail->Port = 587;
        $this->mail->SMTPAuth = true;
        $this->mail->SMTPSecure = 'tls';
        $this->mail->CharSet = 'utf-8';
        $this->mail->ContentType = 'text/html';
        
        /* Descomentado sólo en servidor local */
        // $this->mail->SMTPOptions = array(
        //     'ssl' => array(
        //         'verify_peer'  => false,
        //         'verify_depth' => 3,
        //         'allow_self_signed' => true,
        //         'peer_name' => $this->mail->Host,
        //         'cafile' => '/etc/ssl/certs/cacert.pem',
        //     ),
        //     'tls' => array(
        //         'verify_peer'  => false,
        //         'verify_depth' => 3,
        //         'allow_self_signed' => true,
        //         'peer_name' => $this->mail->Host,
        //         'cafile' => '/etc/ssl/certs/cacert.pem',
        //     ),
        // );
    }

    public function run() {
        $this->setFrom();
        $this->setTo();
        $this->setCc();
        $this->setSubject();
        $this->setBody();
       try {
            if(!$this->mail->Send()) {
//                echo 'Message could not be sent.';
//                echo 'Mailer Error: ' . $this->mail->ErrorInfo;   
            } else {
//                echo "enviado!";   
            }
        } catch (phpmailerException $e) {
//          echo $e->errorMessage(); //Pretty error messages from PHPMailer
        } catch (Exception $e) {
//          echo $e->getMessage(); //Boring error messages from anything else!
        }
    }

    /**
     * Asignar la dirección de envío
     */
    public function setFrom() {
        if (isset($this->params['from'])) {
            $this->mail->SetFrom($this->params['from'][0], $this->params['from'][1]);
        } else {
            $this->mail->SetFrom('no-reply@proces.com.mx', 'Proces Administración');
        }
    }

    /**
     * Asignar la(s) dirección(es) de destino
     */
    public function setTo() {
        foreach ($this->params['to'] as $email => $name) {
            $this->mail->AddAddress($email, $name);
        }
    }

    /**
     * Asignar la dirección de envío copia
     */
    public function setCc() {
        if (isset($this->params['cc'])) {
            foreach ($this->params['cc'] as $email => $name) {
                $this->mail->AddCC($email, $name);
            }
        }
    }

    /**
     * Asignar el encabezado
     */
    public function setSubject() {
        if (isset($this->params['subject'])) {
            $this->mail->Subject = $this->params['subject'];
        } else {
            $this->mail->Subject = $this->t($this->view);
        }
    }

    /**
     * Asignar el cuerpo en funcion a la vista
     */
    public function setBody() {
        $this->mail->MsgHTML($this->render($this->view, $this->params['content'], true));
    }

}