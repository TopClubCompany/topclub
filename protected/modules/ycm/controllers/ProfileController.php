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
				'actions' => array('index', 'edit'),
				'roles' => array('administrator','maineditor', 'editor', 'moderator', 'user')
			)
		);
	}

	/*public function actionIndex() {
		$this->breadcrumbs = array(
			Yii::t('YcmModule.profile', 'my_profile')
		);
		
		$model = new ProfileModel('search');
		$render = $_GET['ajax'] ? 'renderPartial' : 'render';
		$this->$render('index', array(
				'model'=>$model,
		));
	}*/

	public function actionEdit() {
		
		$this->breadcrumbs = array(
			Yii::t('YcmModule.profile', 'my_profile') => array('profile/edit'),
		);
		
		
		$user_id = Yii::app()->user->id;
		$ProfileModel = ProfileModel::model()->findByPk($user_id);
		$ProfileModel->setScenario('formsubmit');
		unset($ProfileModel->password);
		
		if ($_POST['ProfileModel']) {
			$ProfileModel->attributes = $_POST['ProfileModel'];
			if ($ProfileModel->validate()) {
				$ProfileModel->save(false);
				if ($_POST['_save']) {
					$redirect = array('profile/index');
				} else if ($_POST['_addanother']) {
					$redirect = array('profile/add');
				} else if ($_POST['_continue']) {
					$redirect = array('profile/edit', 'user_id' => $ProfileModel->user_id);
				} else {
					$redirect = array('profile/index');
				}
				$this->redirect($redirect);
			}
		}
		$this->render('edit', array(
			'model' => $ProfileModel
		));
	}
}