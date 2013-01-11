<?php

class FiltersController extends AdminController {

	public function actionIndex() {
		$this->breadcrumbs = array(
			Yii::t('YcmModule.filters', 'Filters'),
		);
		$render = $_GET['ajax'] ? 'renderPartial' : 'render';
		$this->$render('index');
	}

	public function actionAdd() {
		$this->actionEdit();
	}

	public function actionEdit() {
		$actionName = strtolower($this->action->id);
		if ($filter_id = (int) $_GET['filter_id'] ? : null) {
			$FiltersModel = FiltersModel::model()->findByPk($filter_id);
		} else {
			$FiltersModel = new FiltersModel;
		}
		$this->breadcrumbs = array(
			Yii::t('YcmModule.filters', 'Filters') => array('Filters/index'),
		);
		if ($actionName == 'add') {
			$this->breadcrumbs[] = Yii::t('YcmModule.filters', 'Add filter');
		} else {
			$this->breadcrumbs[] = Yii::t('YcmModule.filters', 'Edit filter');
		}
		if ($_POST['FiltersModel']) {
			$FiltersModel->attributes = $_POST['FiltersModel'];
			if ($FiltersModel->validate()) {
				$FiltersModel->save(false);
				foreach (LanguageModel::model()->enabled()->findAll() as $language) {
					if (!$filter_id) {
						$FiltersDescModel = new FiltersDescModel;
					} else {
						$FiltersDescModel = FiltersDescModel::model()->find('filter_id=:filter_id AND language_id=:language_id', array(':filter_id' => $FiltersModel->filter_id, ':language_id' => $language->language_id));
					}
					$FiltersDescModel->attributes = array_merge($_POST[$language->code], array(
						'language_id' => $language->language_id,
						'filter_id' => $FiltersModel->filter_id,
							));
					$FiltersDescModel->save(false);
				}
			}

			if ($_POST['_save']) {
				$redirect = array('Filters/index');
			} else if ($_POST['_addanother']) {
				$redirect = array('Filters/add');
			} else if ($_POST['_continue']) {
				$redirect = array('Filters/edit', 'filter_id' => $FiltersModel->filter_id);
			} else {
				$redirect = array('Filters/index');
			}
			$this->redirect($redirect);
		}

		$tabs = array();
		foreach (LanguageModel::model()->enabled()->findAll() as $key => $language) {
			$tabs[] = array(
				'active' => $key == 0 ? true : false,
				'label' => $language->name,
				'content' => $this->renderPartial('_edit_desc', array('langCode' => $language->code, 'model' => $FiltersModel->{$language->code}), true),
			);
		}

		$this->render('edit', array(
			'FiltersModel' => $FiltersModel,
			'tabs' => $tabs
		));
	}

	public function actionDelete() {
		if (!$filter_id = (int) $_GET['filter_id'] ? : null) {
			throw new CHttpException(404);
		}
		if (!$FiltersModel = FiltersModel::model()->findByPk($filter_id)) {
			throw new CHttpException(404);
		}
		$FiltersModel->delete();
		if (!$_GET['ajax'])
			$this->redirect(array('Filters/index'));
	}

}