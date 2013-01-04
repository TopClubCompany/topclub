<?php

class FiltersValuesController extends AdminController {

	private function indexSearch() {
		$criteria = new CDbCriteria();
		if ($filter_id = (int) $_GET['filter_id'] ?: null) {
			$criteria->addCondition('filter_id=:filter_id');
			$criteria->params = array_merge($criteria->params, array(
				':filter_id' => $filter_id
			));
		}
		return new CActiveDataProvider('FiltersValuesModel', array(
			'criteria' => $criteria
		));
	}
	
	public function actionIndex() {
		$this->render('index', array(
			'dataProvider' => $this->indexSearch(),
		));
	}

	public function actionAdd() {
		$this->actionEdit();
	}

	public function actionEdit() {
		$actionName = Yii::app()->controller->action->id;
		if (!$value_id = (int) $_GET['valueid'] ?: null) {
			$FiltersValuesModel = new FiltersValuesModel;
		} else {
			$FiltersValuesModel = FiltersValuesModel::model()->findByPk($value_id);
		}

		$render = $_GET['ajax'] ? 'renderPartial' : 'render';

		$this->$render('edit', array(
			'FiltersValuesModel' => $FiltersValuesModel
		));
	}

	public function actionDelete() {
		
	}

}
