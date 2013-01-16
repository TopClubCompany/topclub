<?php

/**
 * Description of UsersController
 *
 * @author tolyamba
 */
class AlbumsController extends AdminController {

	public function filters() {
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
			Yii::t('YcmModule.albums', 'albums')
		);
		$this->render("index");
	}

	public function actionEdit() {
		
		$this->breadcrumbs = array(
			Yii::t('YcmModule.albums', 'albums') => array('albums/index'),
		);
		
		$this->buttons = array(
			array(
				'buttonType' => 'submit',
				'label' => Yii::t('YcmModule.ycm', 'Update'),
				'url' => array(Yii::app()->controller->id . '/edit'),
				'htmlOptions' => array('name' => '_update', 'value' => '1', 'style' => 'margin-left:10px;')
			),
			array(
				'buttonType' => 'submit',
				'label' => Yii::t('YcmModule.ycm', 'Edit {name}'),
				'url' => array(Yii::app()->controller->id . '/edit'),
				'htmlOptions' => array('name' => '_edit', 'value' => '1', 'style' => 'margin-left:10px;')
			)
		);
		
		if ($album_id = (int) $_GET['album_id'] ? : null) {
			$AlbumsModel = AlbumsModel::model()->findByPk($album_id);
			$AlbumsModel->setScenario('formupdate');
		} else {
			$AlbumsModel = new AlbumsModel('formupdate');
		}
		
		$AlbumsModel = AlbumsModel::model()->findByPk($album_id);
		$AlbumsModel->setScenario('formupdate');
		
		if ($_POST['AlbumsModel']) {
			$AlbumsModel->attributes = $_POST['AlbumsModel'];

			if ($AlbumsModel->validate()) {
				$AlbumsModel->save(false);
				var_dump($_POST['_update']);
				if ($_POST['_update']) {
					$redirect = array('albums/index');
				} else if ($_POST['_edit']){
					$redirect = array('albums/edit', 'album_id' => $AlbumsModel->album_id );
				}
				$this->redirect($redirect);
			}
		}
		$this->render('edit', array(
			'model' => $AlbumsModel
		));
	}
	
	public function actionShow(){
		if ($album_id = (int) $_GET['album_id'] ? : null) {
			$n = PhotosModel::model()->count('album_id=:album_id', array(':album_id' => $album_id));
			if($n > 0){
				$this->render('show');
			} else {
				//need to test this url
				$this->redirect('albums/index');
			}
		} else {
			$this->redirect('albums/index');
		}
	}
}