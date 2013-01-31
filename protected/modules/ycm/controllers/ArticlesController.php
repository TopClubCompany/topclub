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
		$CommentsModel = new CommentsModel;
		$this->$render('index', array(
			'CommentsModel' => $CommentsModel
		));
	}

	public function actionAdd() {
		$this->actionEdit();
	}

	public function actionEdit() {
		$comment_id = (int) $_GET['comment_id'] ? : null;
		$this->breadcrumbs = array(
			Yii::t('YcmModule.comments', 'Comments') => array('comments/index'),
		);
		$this->buttons = $this->getFormButtons();

		if ($comment_id) {
			$this->buttons = array_merge($this->buttons, array(
				array(
					'buttonType' => 'link',
					'label' => Yii::t('YcmModule.ycm', 'Delete'),
					'url' => array(Yii::app()->controller->id . '/delete', 'comment_id' => $comment_id),
					'htmlOptions' => array('name' => '_delete', 'value' => '1', 'style' => 'margin-left:10px;', 'class' => 'btn btn-danger')
				)
			));
		}
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