<?php

class PlacesCategoriesController extends AdminController {

	public function placesCategories() {
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
			Yii::t('YcmModule.placesCategories', 'Categories Places'),
		);
		$render = $_GET['ajax'] ? 'renderPartial' : 'render';
		$this->$render('index');
	}

	public function actionAdd() {
		$this->actionEdit();
	}

	public function actionEdit() {
		$actionName = strtolower($this->action->id);
		if ($category_id = (int) $_GET['category_id'] ? : null) {
			$PlacesCategoriesModel = PlacesCategoriesModel::model()->findByPk($category_id);
		} else {
			$PlacesCategoriesModel = new PlacesCategoriesModel;
		}
		$this->breadcrumbs = array(
			Yii::t('YcmModule.placesCategories', 'Categories Places') => array('PlacesCategories/index'),
		);
		if ($actionName == 'add') {
			$this->breadcrumbs[] = Yii::t('YcmModule.placesCategories', 'Add category place');
		} else {
			$this->breadcrumbs[] = Yii::t('YcmModule.placesCategories', 'Edit category place');
		}
		if ($_POST['PlacesCategoriesModel']) {
			$PlacesCategoriesModel->attributes = $_POST['PlacesCategoriesModel'];
			if ($PlacesCategoriesModel->validate()) {
				$PlacesCategoriesModel->save(false);
				//save places desc
				foreach (LanguageModel::model()->enabled()->findAll() as $language) {
					if (!$category_id) {
						$PlacesCategoriesDescModel = new PlacesCategoriesDescModel;
					} else {
						$PlacesCategoriesDescModel = PlacesCategoriesDescModel::model()->find('category_id=:category_id AND language_id=:language_id', array(':category_id' => $PlacesCategoriesModel->category_id, ':language_id' => $language->language_id));
					}
					$PlacesCategoriesDescModel->attributes = array_merge($_POST[$language->code], array(
						'language_id' => $language->language_id,
						'category_id' => $PlacesCategoriesModel->category_id,
							));
					$PlacesCategoriesDescModel->save(false);
				}
				
				//save places filter
				$filters = $_POST["Filters"];
				PlacesCategoriesToFiltersModel::model()->deleteAll('category_id=:category_id', array(':category_id' => $category_id));
				for($i = 0; $i < count($filters); $i++){
					$PlacesCategoriesToFiltersModel = new PlacesCategoriesToFiltersModel;
					$PlacesCategoriesToFiltersModel->category_id = $category_id;
					$PlacesCategoriesToFiltersModel->filter_id = $filters[$i];
					$PlacesCategoriesToFiltersModel->save(false);
					echo $filters[$i];
					
				}
			}

			if ($_POST['_save']) {
				$redirect = array('PlacesCategories/index');
			} else if ($_POST['_addanother']) {
				$redirect = array('PlacesCategories/add');
			} else if ($_POST['_continue']) {
				$redirect = array('PlacesCategories/edit', 'category_id' => $PlacesCategoriesModel->category_id);
			} else {
				$redirect = array('PlacesCategories/index');
			}
			$this->redirect($redirect);
		}

		$tabs = array();
		foreach (LanguageModel::model()->enabled()->findAll() as $key => $language) {
			$tabs[] = array(
				'active' => $key == 0 ? true : false,
				'label' => $language->name,
				'content' => $this->renderPartial('_edit_desc', array('langCode' => $language->code, 'model' => $PlacesCategoriesModel->{$language->code}), true),
			);
		}
		
		//FILTERS DATA
		//array of selected filters of current category
		$selectedFilters = array();
		$categories = PlacesCategoriesToFiltersModel::model()->findAll('category_id=:category_id', array(':category_id' => $PlacesCategoriesModel->category_id));
		foreach($categories as $filters){
			$selectedFilters[$filters->filter_id] = array('selected' => 'selected');
		}
		//current language
		$language_id = LanguageModel::model()->find('code=:code', array(':code' => Yii::app()->language))->language_id;
		//return all localize filters
		$filtersArray = CHtml::listData(
				FiltersDescModel::model()->findAll('language_id=:language_id', array(':language_id' => $language_id)),
				"filter_id", 
				'name'
		);
		
		$this->render('edit', array(
			'PlacesCategoriesModel' => $PlacesCategoriesModel,
			'tabs' => $tabs,
			'selectedFilters' => $selectedFilters,
			'filtersArray' => $filtersArray,
		));
	}

	public function actionDelete() {
		if (!$category_id = (int) $_GET['category_id'] ? : null) {
			throw new CHttpException(404);
		}
		if (!$PlacesCategoriesModel = PlacesCategoriesModel::model()->findByPk($category_id)) {
			throw new CHttpException(404);
		}
		$PlacesCategoriesModel->delete();
		if (!$_GET['ajax'])
			$this->redirect(array('PlacesCategories/index'));
	}

}