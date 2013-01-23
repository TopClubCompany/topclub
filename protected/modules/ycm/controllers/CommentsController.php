<?php

/**
 * Description of UsersController
 *
 * @author tolyamba
 */
class CommentsController extends AdminController {

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
			Yii::t('YcmModule.comments', 'Comments')
		);
		$render = $_GET['ajax'] ? 'renderPartial' : 'render';
		$this->$render('index');
	}

	public function actionAdd() {
		$this->actionEdit();
	}

	public function actionEdit() {

		$this->breadcrumbs = array(
			Yii::t('YcmModule.comments', 'Comments') => array('comments/index'),
		);

		if ($comment_id = (int) $_GET['comment_id'] ? : null) {
			$CommentsModel = CommentsModel::model()->findByPk($comment_id);
			$CommentsModel->setScenario('formupdate');
			$this->breadcrumbs = array_merge($this->breadcrumbs, array(
				Yii::t('YcmModule.comments', 'Edit comment')
			));
		} else {
			$CommentsModel = new CommentsModel('formupdate');
			$this->breadcrumbs = array_merge($this->breadcrumbs, array(
				Yii::t('YcmModule.comments', 'Add comment')
			));
		}
		if ($_POST['CommentsModel']) {
			$CommentsModel->attributes = $_POST['CommentsModel'];
			if ($CommentsModel->validate()) {
				$CommentsModel->save(false);
				if ($_POST['_save']) {
					$redirect = array('comments/index');
				} else if ($_POST['_addanother']) {
					$redirect = array('comments/add');
				} else if ($_POST['_continue']) {
					$redirect = array('comments/edit', 'comment_id' => $CommentsModel->comment_id);
				} else {
					$redirect = array('comments/index');
				}
				$this->redirect($redirect);
			}
		}
		$this->render('edit', array(
			'model' => $CommentsModel
		));
	}

	public function actionDelete() {
		if (!$comment_id = (int) $_GET['comment_id'] ? : null) {
			throw new CHttpException(404);
		}
		if (!$CommentsModel = CommentsModel::model()->findByPk($comment_id)) {
			throw new CHttpException(404);
		}
		$CommentsModel->delete();
		if (!$_GET['ajax'])
			$this->redirect(array('Comments/index'));
	}

	
	
}