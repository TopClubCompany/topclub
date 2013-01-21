<?php

/**
 * Description of UsersController
 *
 * @author tolyamba
 */
class UsersController extends AdminController {

	public function filters() {
		return array(
			'accessControl'
		);
	}

	public function accessRules() {
		return array(
			array(
				'allow',
				'actions' => array('index', 'edit', 'add', 'delete'),
				'roles' => array('administrator')
			),
			array(
				'deny',
				'actions' => array('index', 'edit', 'add', 'delete'),
				'roles' => array('maineditor', 'editor', 'moderator', 'user', 'guest')
			)
		);
	}

	public function actionIndex() {
		$this->breadcrumbs = array(
			Yii::t('YcmModule.users', 'Users')
		);
		$render = $_GET['ajax'] ? 'renderPartial' : 'render';
		$this->$render('index');
	}

	public function actionAdd() {
		$this->actionEdit();
	}

	public function actionEdit() {
		$actionId = strtolower(Yii::app()->controller->action->id);
		$this->breadcrumbs = array(
			Yii::t('YcmModule.users', 'Users') => array('users/index'),
		);
		if ($actionId == 'add') {
			$this->breadcrumbs = array_merge($this->breadcrumbs, array(
				Yii::t('YcmModule.users', 'Add user')
			));
		} else if ($actionId == 'edit') {
			$this->breadcrumbs = array_merge($this->breadcrumbs, array(
				Yii::t('YcmModule.users', 'Edit user')
			));
		}
		if ($user_id = (int) $_GET['user_id'] ? : null) {
			$UsersModel = UsersModel::model()->findByPk($user_id);
			$UsersModel->setScenario('formsubmit');
			unset($UsersModel->password);
		} else {
			$UsersModel = new UsersModel('formsubmit');
		}
		if ($_POST['UsersModel']) {
			$UsersModel->attributes = $_POST['UsersModel'];
			if ($UsersModel->validate()) {
				$UsersModel->save(false);
				if ($_POST['_save']) {
					$redirect = array('users/index');
				} else if ($_POST['_addanother']) {
					$redirect = array('users/add');
				} else if ($_POST['_continue']) {
					$redirect = array('users/edit', 'user_id' => $UsersModel->user_id);
				} else {
					$redirect = array('users/index');
				}
				$this->redirect($redirect);
			}
		}
		$this->render('edit', array(
			'model' => $UsersModel
		));
	}

	public function actionDelete() {
		if ($user_id = (int) $_GET['user_id'] ? : null) {
			if (!$um = UsersModel::model()->findByPk($user_id)) {
				throw new CHttpException(404);
			}
			$um->delete();
		} else {
			throw new CHttpException(404);
		}
		if (!$_GET['ajax'])
			$this->redirect(array('users/index'));
	}

}