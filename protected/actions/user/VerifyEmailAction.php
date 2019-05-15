<?php

class VerifyEmailAction extends CAction {

	public function run() {

		$token = Yii::app()->request->getParam('token', null);
		$system = Yii::app()->request->getParam('system', null);

		$user = User::model()->findByAttributes(array(
			'email_confirm_token' => Yii::app()->securityManager->decrypt(base64_decode($token))
		), "email_confirm_token IS NOT NULL");

		if(!$user) {
			throw new CHttpException(400, Yii::t('yii', 'Your request is invalid.'));
		}

		$success = false;

		try {
			$transaction = Yii::app()->db->getCurrentTransaction() ? null : Yii::app()->db->beginTransaction();
		   
			$user->email_confirmed = UserModel::EMAIL_CONFIRMED;

			$success = $user->update(array('email_confirmed'));

			if ($success) {
				$transaction ? $transaction->commit() : null;
			}
		} catch (Exception $e) {
			$transaction ? $transaction->rollback() : null;
			$success = false;
		}
		
		if($success) {

			$product = Product::model()->findByAttributes(array(
				'keyword' => Yii::app()->securityManager->decrypt(base64_decode($system))
			));

			$redirect = Yii::app()->getBaseUrl(true);

			if ($product) {
				$localProduct = Product::model()->findByAttributes(array(
					'token' => Yii::app()->params->token
				));

				$redirect = str_replace($localProduct->url_product, $product->url_product, $redirect);
			}

			$this->controller->redirect($redirect);

		} else {
			throw new CHttpException(400, 'Lo sentimos, ocurrio un error.');
		}

	}


}