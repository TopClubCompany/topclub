<?php

class FiltersValuesController extends AdminController {

	public function actionIndex() {
		$this->breadcrumbs = array(
			Yii::t('YcmModule.filters', 'Filters')
		);
		if ($filter_id = (int) $_GET['FiltersValuesModel']['filter_id'] ? : null) {
			$this->buttons = array(
				array(
					'type' => 'primary',
					'label' => Yii::t('YcmModule.ycm', 'Create'),
					'url' => array(Yii::app()->controller->id . '/add', 'FiltersValuesModel[filter_id]' => $filter_id),
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

		if (Yii::app()->controller->action->id == 'edit') {
			$this->breadcrumbs += array(
				Yii::t('YcmModule.filters', 'Edit filter value')
			);
		} else {
			$this->breadcrumbs += array(
				Yii::t('YcmModule.filters', 'Add filter value')
			);
		}

		$render = $_GET['ajax'] ? 'renderPartial' : 'render';
		/*print_r($FiltersValuesModel->attributeWidgets());
		die;*/
		$this->$render('edit', array(
			'FiltersValuesModel' => $FiltersValuesModel
		));
	}

	public function actionDelete() {
		
	}

}
