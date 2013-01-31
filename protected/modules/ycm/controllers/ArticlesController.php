<?php

/**
 * Description of UsersController
 *
 * @author tolyamba
 */
class ArticlesController extends AdminController {

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
			Yii::t('YcmModule.articles', 'Articles')
		);
		$render = $_GET['ajax'] ? 'renderPartial' : 'render';
		$ArticlesModel = new ArticlesModel;
		$this->$render('index', array(
			'ArticlesModel' => $ArticlesModel
		));
	}

	public function actionAdd() {
		$this->actionEdit();
	}

	public function actionEdit() {
		$article_id = (int) $_GET['article_id'] ? : null;
		$this->breadcrumbs = array(
			Yii::t('YcmModule.articles', 'Articles') => array('articles/index'),
		);
		
		if ($article_id = (int) $_GET['article_id'] ? : null) {
			$ArticlesModel = ArticlesModel::model()->findByPk($article_id);
			$this->breadcrumbs = array_merge($this->breadcrumbs, array(
				Yii::t('YcmModule.articles', 'Edit article')
					));
		} else {
			$ArticlesModel = new ArticlesModel();
			$this->breadcrumbs = array_merge($this->breadcrumbs, array(
				Yii::t('YcmModule.articles', 'Add article')
			));
		}
		if ($_POST['ArticlesModel']) {
			$ArticlesModel->attributes = $_POST['ArticlesModel'];
			if ($ArticlesModel->validate()) {
				if ($image = CUploadedFile::getInstance(ArticlesModel::model(), 'image')) {
					$articleDir = $path = Yii::app()->getBasePath() . "/../uploads/articles/";
					if (!is_dir($path)) {
						mkdir($path);
						chmod($path, 0777);
					}
					$extName = $image->getExtensionName();
					$path = Yii::app()->getBasePath() . "/../uploads/articles/{$article_id}/";
					$filename = $ArticlesModel->url . "_cover." . $extName;
					
					if (!is_dir($path)) {
						mkdir($path);
						chmod($path, 0777);
					}

					if (is_file($image->getTempName())) {
						if (rename($image->getTempName(), $path . $filename)) {
							chmod($path . $filename, 0777);
							$ArticlesModel->pub_cover = $filename;
							$ArticlesModel->save(false);
						}
					}
				} else {
					$ArticlesModel->save(false);
				}
				if ($_POST['_save']) {
					$redirect = array('articles/index');
				} else if ($_POST['_addanother']) {
					$redirect = array('articles/add');
				} else if ($_POST['_continue']) {
					$redirect = array('articles/edit', 'article_id' => $ArticlesModel->article_id);
				} else {
					$redirect = array('articles/index');
				}
				$this->redirect($redirect);
			}
		}
		$this->render('edit', array(
			'model' => $ArticlesModel,
		));
	}

	public function actionDelete() {
		if (!$article_id = (int) $_GET['article_id'] ? : null) {
			throw new CHttpException(404);
		}
		if (!$ArticlesModel = ArticlesModel::model()->findByPk($article_id)) {
			throw new CHttpException(404);
		}
		$ArticlesModel->delete();
		if (!$_GET['ajax'])
			$this->redirect(array('Articles/index'));
	}

}