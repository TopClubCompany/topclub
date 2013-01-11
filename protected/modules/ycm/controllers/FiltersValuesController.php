<?php

class FiltersValuesController extends AdminController {

	public function actionIndex() {
		$this->breadcrumbs = array(
			Yii::t('YcmModule.filters', 'Filters')
		);
		if ($value_id = (int) $_GET['FiltersValuesModel']['value_id'] ? : null) {
			$this->buttons = array(
				array(
					'type' => 'primary',
					'label' => Yii::t('YcmModule.ycm', 'Create'),
					'url' => array(Yii::app()->controller->id . '/add', 'FiltersValuesModel[value_id]' => $value_id),
					'htmlOptions' => array(
						'id' => 'create-button'
					)
				)
			);
		}
		$render = $_GET['ajax'] ? 'renderPartial' : 'render';
		$this->$render('index', array(
			'FiltersValuesModel' => FiltersValuesModel::model(),
		));
	}

	public function actionAdd() {
		$this->actionEdit();
	}

	public function actionEdit() {
		$actionName = Yii::app()->controller->action->id;
		if (!$value_id = (int) $_GET['valueid'] ? : null) {
			$FiltersValuesModel = new FiltersValuesModel;
		} else {
			$FiltersValuesModel = FiltersValuesModel::model()->findByPk($value_id);
		}

		$this->breadcrumbs = array(
			Yii::t('YcmModule.filters', 'Filters values') => array('FiltersValues/index'),
		);

		if($actionName == 'add') {
			$this->breadcrumbs += array(
				Yii::t('YcmModule.filters', 'Add filter value')
			);
		} else if ($actionName == 'edit') {
			$this->breadcrumbs += array(
				Yii::t('YcmModule.filters', 'Edit filter value')
			);
		} else {
			$this->breadcrumbs += array(
				Yii::t('YcmModule.filters', 'Something else')
			);
		}

		if ($filter_id = (int) $_GET['filter_id'] ? : null) {
			$FiltersValuesModel = UsersModel::model()->findByPk($filter_id);
			$FiltersValuesModel->setScenario('add_filter_value');
		} else {
			$FiltersValuesModel = new FiltersValuesModel('add_filter_value');
		}
		if ($_POST['FiltersValuesModel']) {
			$FiltersValuesModel->attributes = $_POST['FiltersValuesModel'];
			if ($FiltersValuesModel->validate()) {
				$FiltersValuesModel->save(false);
						
				foreach (LanguageModel::model()->enabled()->findAll() as $language) {
					if (!$filter_id) {
						$FiltersValuesDescModel = new FiltersValuesDescModel;
					} else {
						$FiltersValuesDescModel = FiltersValuesDescModel::model()->find('value_id=:value_id AND language_id=:language_id', array(':value_id' => $FiltersValuesModel->value_id, ':language_id' => $language->language_id));
					}
					$FiltersValuesDescModel->attributes = array_merge($_POST[$language->code], array(
						'language_id' => $language->language_id,
						'value_id' => $FiltersValuesModel->value_id,
					));
					$FiltersValuesDescModel->save(false);
				}
				
				if ($_POST['_save']) {
					$redirect = array('FiltersValues/index');
				} else if ($_POST['_addanother']) {
					$redirect = array('FiltersValues/add');
				} else if ($_POST['_continue']) {
					$redirect = array('FiltersValues/edit', 'filter_id' => $FiltersValuesModel->filter_id);
				} else {
					$redirect = array('FiltersValues/index');
				}
				$this->redirect($redirect);
			}
		}
		
		$tabs = array();
		foreach (LanguageModel::model()->enabled()->findAll() as $key => $language) {
			$tabs[] = array(
				'active' => $key == 0 ? true : false,
				'label' => $language->name,
				'content' => $this->renderPartial('_edit_desc', array('langCode' => $language->code, 'model' => $FiltersValuesModel->{$language->code}), true),
			);
		}
		
		$render = $_GET['ajax'] ? 'renderPartial' : 'render';
		$this->$render('edit', array(
			'FiltersValuesModel' => $FiltersValuesModel,
			'tabs' => $tabs
		));
	}

	public function actionDelete() {
		if (!$filter_id = (int) $_GET['filter_id'] ? : null) {
			throw new CHttpException(404);
		}
		if (!$FiltersValuesModel = FiltersValuesModel::model()->findByPk($filter_id)) {
			throw new CHttpException(404);
		}
		$FiltersValuesModel->delete();
		if (!$_GET['ajax'])
			$this->redirect(array('FiltersValues/index'));
	}

}
