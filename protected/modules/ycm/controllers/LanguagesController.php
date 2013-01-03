<?php

/**
 * Description of LanguagesController
 *
 * @author shults
 */
class LanguagesController extends AdminController {

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
			Yii::t('YcmModule.languages', 'Languages')
		);
		$render = $_GET['ajax'] ? 'renderPartial' : 'render';
		$this->$render('index');
	}

	public function actionAdd() {
		$this->actionEdit();
	}

	public function actionEdit() {
		$actionName = strtolower($this->action->id);
		if ($language_id = (int) $_GET['language_id'] ? : null) {
			$LanguageModel = LanguageModel::model()->findByPk($language_id);
		} else {
			$LanguageModel = new LanguageModel();
		}
		
		$this->breadcrumbs = array(
			Yii::t('YcmModule.languages', 'Languages') => array('Languages/index'),
		);
		
		if ($actionName == 'add') {
			$this->breadcrumbs[] = Yii::t('YcmModule.languages', 'Add language');
		} else {
			$this->breadcrumbs[] = Yii::t('YcmModule.languages', 'Edit language');
		}
		if ($_POST['LanguageModel']) {
			$LanguageModel->attributes = $_POST['LanguageModel'];
			if ($LanguageModel->validate()) {
				$LanguageModel->save(false);
				if ($_POST['_save']) {
					$redirect = array('languages/index');
				} else if ($_POST['_addanother']) {
					$redirect = array('languages/add');
				} else if ($_POST['_continue']) {
					$redirect = array('languages/edit', 'language_id' => $LanguageModel->language_id);
				} else {
					$redirect = array('languages/index');
				}
				$this->redirect($redirect);
			}
		}
		$this->render('edit', array(
			'model' => $LanguageModel
		));
	}

}