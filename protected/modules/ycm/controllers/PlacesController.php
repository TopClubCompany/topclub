<?php

class PlacesController extends AdminController {

	public function init() {
		Yii::import("xupload.models.XUploadForm");
		return parent::init();
	}

	public function filters() {
		return array(
			'accessControl'
		);
	}

	public function actions() {
		return array(
			'upload' => array(
				'class' => 'application.modules.ycm.actions.UploadAction',
				'folder' => 'places', //folder should be named like Controller
			),
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
			Yii::t('YcmModule.places', 'Places'),
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
			Yii::t('YcmModule.places', 'Places') => array('places/index'),
		);
		if ($actionId == 'add') {
			$this->breadcrumbs = array_merge($this->breadcrumbs, array(
				Yii::t('YcmModule.places', 'Add place')
					));
		} else if ($actionId == 'edit') {
			$this->breadcrumbs = array_merge($this->breadcrumbs, array(
				Yii::t('YcmModule.places', 'Edit place')
					));
		}
		if ($place_id = (int) $_GET['place_id'] ? : null) {
			$PlacesModel = PlacesModel::model()->findByPk($place_id);
			$PlacesModel->setScenario('formsubmit');
		} else {
			$PlacesModel = new PlacesModel('formsubmit');
		}
		if ($_POST['PlacesModel']) {
			$PlacesModel->attributes = $_POST['PlacesModel'];
			$submodelsValid = true;
			foreach ($languages = LanguageModel::model()->enabled()->findAll() as $language) {
				$PlacesModel->{$language->code}->attributes = $_POST[$language->code];
				if (!$PlacesModel->{$language->code}->validate())
					$submodelsValid = false;
			}
			if ($PlacesModel->validate() && $submodelsValid) {
				$PlacesModel->save(false);
				foreach ($languages as $language) {
					$PlacesModel->{$language->code}->save(false);
				}
				if ($_POST['_save']) {
					$redirect = array('places/index');
				} else if ($_POST['_addanother']) {
					$redirect = array('places/add');
				} else if ($_POST['_continue']) {
					$redirect = array('places/edit', 'place_id' => $PlacesModel->place_id);
				} else {
					$redirect = array('places/index');
				}
				$this->redirect($redirect);
			}
		}
		$tabs = array();
		foreach (LanguageModel::model()->enabled()->findAll() as $key => $language) {
			$tabs[] = array(
				'active' => $key == 0 ? true : false,
				'label' => $language->name,
				'content' => $this->renderPartial('_edit_desc', array('langCode' => $language->code, 'model' => $PlacesModel->{$language->code}), true),
			);
		}
		Yii::import("xupload.models.XUploadForm");
		$photos = new XUploadForm;
		$this->render('edit', array(
			'model' => $PlacesModel,
			'tabs' => $tabs,
			'photos' => $photos
		));
	}

	public function actionDelete() {
		if ($place_id = (int) $_GET['place_id'] ? : null) {
			if (!$um = PlacesModel::model()->findByPk($place_id)) {
				throw new CHttpException(404);
			}
			$um->delete();
		} else {
			throw new CHttpException(404);
		}
		if (!$_GET['ajax'])
			$this->redirect(array('places/index'));
	}

	public function actionDeleteImage() {
		if ($photo_id = (int) $_GET['photo_id'] ? : null) {
			if (!$um = PlacesPhotoModel::model()->findByPk($photo_id)) {
				throw new CHttpException(404);
			}
			$um->delete();
			//add unlink file !!!
		} else {
			throw new CHttpException(404);
		}
		if (!$_GET['ajax'])
			$this->redirect(array('places/index'));
	}
}