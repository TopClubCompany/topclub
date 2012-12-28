<?php

/**
 * Description of LanguagesController
 *
 * @author shults
 */
class LanguagesController extends AdminController {

	public function accessRules() {
		return array(
			array(
				'allow',
				'actions' => array('index'),
				'roles' => array('*'),
			),
		);
	}

	public function actionIndex() {
		$this->render('index');
	}

	public function actionAdd() {
		$this->actionEdit();
	}

	public function actionEdit() {
		if ($language_id = (int) $_GET[''] ?: null) {
			$LanguageModel = LanguageModel::model()->findByPk($language_id);
		} else {
			$LanguageModel = new LanguageModel();
		}
		if ($_POST['Languages']) {
			$LanguageModel->attributes = $_POST['Languages'];
			if ($LanguageModel->validate()) {
				
			}
			//Yii::app()->end();
		}
		$this->render('edit', array(
			'model' => $LanguageModel
		));
	}

}