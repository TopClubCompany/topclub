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
		$render = $_GET['ajax'] ? 'renderPartial' : 'render';
		$this->$render('index');
	}

	public function actionAdd() {
		$this->actionEdit();
	}

	public function actionEdit() {
	if ($user_id = (int) $_GET['user_id'] ? : null) {
			$UsersModel = UsersModel::model()->findByPk($user_id);
		} else {
			$UsersModel = new UsersModel();
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
    
    public function actionDelete(){
        if ($user_id = (int) $_GET['user_id'] ?: null) {
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