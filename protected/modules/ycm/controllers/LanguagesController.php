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
		$this->render('edit');
	}

}