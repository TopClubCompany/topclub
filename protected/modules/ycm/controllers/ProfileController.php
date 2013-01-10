<?php

/**
 * Description of UsersController
 *
 * @author tolyamba
 */
class ProfileController extends AdminController {

	public function filters() {
		return array(
			'accessControl'
		);
	}

	public function accessRules() {
		return array(
			array(
				'allow',
				'actions' => array('index', 'edit'),
				'roles' => array('administrator','maineditor', 'editor', 'moderator', 'user')
			)
		);
	}
	
	
	/*public function actionIndex() {
		$this->breadcrumbs = array(
			Yii::t('YcmModule.profile', 'my_profile')
		);
		
		$model = new ProfileModel('search');
		$render = $_GET['ajax'] ? 'renderPartial' : 'render';
		$this->$render('index', array(
				'model'=>$model,
		));
	}*/

	public function actionEdit() {
		
		$this->breadcrumbs = array(
			Yii::t('YcmModule.profile', 'my_profile') => array('profile/edit'),
		);
		
		$this->buttons = array(
			array(
				'buttonType' => 'submit',
				'label' => Yii::t('YcmModule.ycm', 'Update'),
				'url' => array(Yii::app()->controller->id . '/edit'),
				'htmlOptions' => array('name' => '_update', 'value' => '1', 'style' => 'margin-left:10px;')
			)
		);
		
		$user_id = Yii::app()->user->id;
		$UsersModel = UsersModel::model()->findByPk($user_id);
		$UsersModel->setScenario('formupdate');
		unset($UsersModel->password);
		if ($_POST['UsersModel']) {
			$UsersModel->attributes = $_POST['UsersModel'];

			if ($UsersModel->validate()) {
				
				$UsersModel->save(false);
				var_dump($_POST['_update']);
				if ($_POST['_update']) {
					$redirect = array('profile/edit');
				}
				$this->redirect($redirect);
			}
		}
		$this->render('edit', array(
			'model' => $UsersModel
		));
	}
}