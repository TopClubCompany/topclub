<?php

/**
 * Description of UsersController
 *
 * @author tolyamba
 */
class ProfileController extends AdminController {

	public function filters() {
		return array(
			'accessControl'
		);
	}

	public function accessRules() {
		return array(
			array(
				'allow',
				'actions' => array('edit'),
				'roles' => array('administrator', 'maineditor', 'editor', 'moderator')
			),
			array(
				'deny',
				'actions' => array('edit'),
				'roles' => array('user'),
			),
		);
	}

	public function actionEdit() {

		$this->breadcrumbs = array(
			Yii::t('YcmModule.profile', 'My profile') => array('profile/edit'),
		);

		$this->buttons = array(
			array(
				'buttonType' => 'submit',
				'label' => Yii::t('YcmModule.ycm', 'Update'),
				'url' => array(Yii::app()->controller->id . '/edit'),
				'htmlOptions' => array('name' => '_update', 'value' => '1', 'style' => 'margin-left:10px;')
			)
		);

		$user_id = Yii::app()->user->id;
		$UsersModel = UsersModel::model()->findByPk($user_id);
		$UsersModel->setScenario('profile_update');
		if ($_POST['UsersModel']) {
			$UsersModel->attributes = $_POST['UsersModel'];
			if ($_POST['UsersModel']["password"] != '' || $_POST['UsersModel']["password_repeat"] != '')
				$UsersModel->password = $_POST['UsersModel']["password"];
			else {
				unset($UsersModel->password);
			}
			if ($UsersModel->validate()) {
				$UsersModel->save(false);
				if ($_POST['_update']) {
					$redirect = array('profile/edit');
				}
				$this->redirect($redirect);
			}
		}
		unset($UsersModel->password);
		$this->render('edit', array(
			'model' => $UsersModel
		));
	}

}