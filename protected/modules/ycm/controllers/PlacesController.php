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

				//save filters
				$category_id = $_POST['PlacesModel']["category_id"];
				$this->saveFilters($category_id, $place_id);

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
	
	public function actionTimetablePopup(){
		$this->renderPartial('_timetable_popup');
	}

	public function actionShowComments() {
		$this->breadcrumbs = array(
			Yii::t('YcmModule.places', 'Places') => array('places/index'),
			Yii::t('YcmModule.places', 'Comments')
		);
		
		$this->render('showComments');
	}

	public function actionShowFilters() {
		if ($category_id = $_GET["category_id"]) {
			$html = '';
			//current language
			$language_id = LanguageModel::model()->enabled()->find('code=:code', array(':code' => Yii::app()->language))->language_id;
			$filtersArray = $this->getFilters($category_id);
			$filters = array();
			foreach ($filtersArray as $filter) {
				$filterName = FiltersDescModel::model()->find('filter_id=:filter_id AND language_id=:language_id', array(':filter_id' => $filter->filter_id, ':language_id' => $language_id))->name;
				$filters[$filterName] = $filter->filter_id;
			}

			$filtersValues = array();
			foreach ($filters as $name => $filterId) {
				$fv = FiltersValuesModel::model()->findAll('filter_id=:filter_id', array(':filter_id' => $filterId));
				$filtersValuesDesc = array();
				foreach ($fv as $filterValue) {

					$fvd = FiltersValuesDescModel::model()->findAll('value_id=:value_id AND language_id=:language_id', array(':value_id' => $filterValue->value_id, ':language_id' => $language_id));
					foreach ($fvd as $filterValueDesc) {
						$filtersValuesDesc[$filterValueDesc->value_id] = $filterValueDesc->name;
					}
				}
				$place_id = $_GET["place_id"];
				$selectedFilters = $this->selectedFilters($filterId, $place_id);
				echo CHtml::dropDownList("filter_id_$filterId", "filters_values_desc$filters[$i]", $filtersValuesDesc, array(
					'multiple' => 'multiple',
					'class' => 'span5 chzn-select',
					'data-placeholder' => Yii::t('YcmModule.places', 'Choose {name}', array('{name}' => $name)),
					'options' => $selectedFilters,
						)
				);
				echo "<br>";
			}
		} else {
			$text = "<span style='display: inline-block; margin-top: 5px;'>";
			$text .= Yii::t("YcmModule.places", "Choose {name}", array("{name}" => "категорию"));
			$text .= "<span>";
			echo $text;
		}
	}

	private function getFilters($_category_id) {
		return PlacesCategoriesToFiltersModel::model()->findAll('category_id=:category_id', array(':category_id' => $_category_id));
	}

	private function selectedFilters($_filterId, $_place_id) {
		$selectedFilters = array();
		$filterPlace = PlacesCategoriesToFiltersValuesModel::model()->findAll('filter_id=:filter_id AND place_id=:place_id', array(':filter_id' => $_filterId, ':place_id' => $_place_id));
		foreach ($filterPlace as $filter) {
			$selectedFilters[$filter->value_id] = array('selected' => 'selected');
		}
		return $selectedFilters;
	}

	private function saveFilters($_category_id, $_place_id) {
		//clean all filters for this palce
		$this->cleanFilterFromDb($_place_id);
		if ($_category_id) {
			$filtersArray = $this->getFilters($_category_id);
			foreach ($filtersArray as $filter) {
				$filter_id = $filter->filter_id;
				$filterArr = $_POST["filter_id_{$filter_id}"];
				if ($filterArr) {
					foreach ($filterArr as $value_id) {
						$pctfvModel = new PlacesCategoriesToFiltersValuesModel();
						$pctfvModel->place_id = $_place_id;
						$pctfvModel->filter_id = $filter_id;
						$pctfvModel->value_id = $value_id;
						$pctfvModel->save(false);
					}
				}
			}
		}
	}

	private function cleanFilterFromDb($_place_id) {
		$deletePlaceFilters = PlacesCategoriesToFiltersValuesModel::model()->findAll('place_id=:place_id', array(':place_id' => $_place_id));
		if ($deletePlaceFilters) {
			PlacesCategoriesToFiltersValuesModel::model()->deleteAll('place_id=:place_id', array(':place_id' => $_place_id));
		}
	}

	public function actionDelete() {
		if ($place_id = (int) $_GET['place_id'] ? : null) {
			if (!$place = PlacesModel::model()->findByPk($place_id)) {
				throw new CHttpException(404);
			}
			$place->delete();
		} else {
			throw new CHttpException(404);
		}
		if (!$_GET['ajax'])
			$this->redirect(array('places/index'));
	}

	public function actionDeleteImage() {
		if ($photo_id = (int) $_GET['photo_id'] ? : null) {
			if (!$photo = PlacesPhotoModel::model()->findByPk($photo_id)) {
				throw new CHttpException(404);
			}
			$photo->delete();
			//add unlink file !!!
		} else {
			throw new CHttpException(404);
		}
		if (!$_GET['ajax'])
			$this->redirect(array('places/index'));
	}

}