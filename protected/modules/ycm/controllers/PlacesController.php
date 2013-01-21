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

	/* public function actions() {
	  return array(
	  'upload' => array(
	  'class' => 'xupload.actions.XUploadAction',
	  'path' => Yii::app()->getBasePath() . "/../uploads",
	  'publicPath' => Yii::app()->getBaseUrl() . "/uploads",
	  //'fileAttribute' => 'files'
	  ),
	  );
	  } */

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
			if ($PlacesModel->validate()) {
				$PlacesModel->save(false);
				//var_dump($_POST['PlacesModel']["place_id"]);die;
				foreach (LanguageModel::model()->enabled()->findAll() as $language) {
					if (!$place_id) {
						$PlacesDescModel = new PlacesDescModel;
					} else {
						$PlacesDescModel = PlacesDescModel::model()->find('place_id=:place_id AND language_id=:language_id', array(':place_id' => $PlacesModel->place_id, ':language_id' => $language->language_id));
					}
					echo "<pre>";

					/* var_dump($_POST[$language->code]);
					  var_dump($language->language_id);
					  var_dump($PlacesModel->place_id);
					  var_dump($PlacesDescModel->attributes);
					  var_dump($PlacesDescModel->attributes = array_merge($_POST[$language->code], array(
					  'language_id' => $language->language_id,
					  'place_id' => $PlacesModel->place_id,
					  )));die; */
					//var_dump($PlacesDescModel); die;
					$PlacesDescModel->attributes = array_merge($_POST[$language->code], array(
						'language_id' => $language->language_id,
						'place_id' => $PlacesModel->place_id,
							));
					//var_dump($PlacesDescModel->attributes);

					$PlacesDescModel->save(false);
				}
				//die;
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
		//var_dump($tabs);die;
		$this->render('edit', array(
			'model' => $PlacesModel,
			'tabs' => $tabs,
			'photos' => $photos
		));
	}

	public function actionDelete() {
		if ($place_id = (int) $_GET['place_id'] ? : null) {
			if (!$um = PlacesModel::model()->findByPk($place_id)) {
				throw new CHttpException(404);
			}
			$um->delete();
		} else {
			throw new CHttpException(404);
		}
		if (!$_GET['ajax'])
			$this->redirect(array('places/index'));
	}

	public function actionDeleteImage() {
		if ($photo_id = (int) $_GET['photo_id'] ? : null) {
			if (!$um = PlacesPhotoModel::model()->findByPk($photo_id)) {
				throw new CHttpException(404);
			}
			$um->delete();
			//add unlink file !!!
		} else {
			throw new CHttpException(404);
		}
		if (!$_GET['ajax'])
			$this->redirect(array('places/index'));
	}

	public function actionUpload() {
		Yii::import("xupload.models.XUploadForm");
		//Here we define the paths where the files will be stored temporarily
		$path = realpath(Yii::app()->getBasePath() . "/../uploads/tmp/") . "/";
		$publicPath = Yii::app()->getBaseUrl() . "/uploads/tmp/";

		//This is for IE which doens't handle 'Content-type: application/json' correctly
		header('Vary: Accept');
		if (isset($_SERVER['HTTP_ACCEPT'])
				&& (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
			header('Content-type: application/json');
		} else {
			header('Content-type: text/plain');
		}

		//Here we check if we are deleting and uploaded file
		if (isset($_GET["_method"])) {
			if ($_GET["_method"] == "delete") {
				//currently not used
				/* if ($_GET["file"][0] !== '.') {
				  $file = $path . $_GET["file"];
				  if (is_file($file)) {
				  unlink($file);
				  }
				  } */
				$name = $_GET["name"];
				$place_id = $_GET["place_id"];
				$photo_id = $_GET["photo_id"];
				$this->deleteImages($place_id, $name, $photo_id);
				echo json_encode(true);
			}
		} else {
			$model = new XUploadForm;
			$model->file = CUploadedFile::getInstance($model, 'file');
			//We check that the file was successfully uploaded
			if ($model->file !== null) {
				//Grab some data
				$model->mime_type = $model->file->getType();
				$model->size = $model->file->getSize();
				$model->name = $model->file->getName();
				$filename = md5(Yii::app()->user->id . microtime() . $model->name);
				$filename .= "." . $model->file->getExtensionName();
				if ($model->validate()) {
					//Move our file to our temporary dir
					$model->file->saveAs($path . $filename);
					chmod($path . $filename, 0777);
					//here you can also generate the image versions you need
					//using something like PHPThumb
					//Now we need to save this path to the user's session
					if (Yii::app()->user->hasState('images')) {
						$userImages = Yii::app()->user->getState('images');
					} else {
						$userImages = array();
					}
					$userImages[] = array(
						"path" => $path . $filename,
						//the same file or a thumb version that you generated
						"thumb" => $path . $filename,
						"filename" => $filename,
						'size' => $model->size,
						'mime' => $model->mime_type,
						'name' => $model->name,
					);
					Yii::app()->user->setState('images', $userImages);

					$place_id = $_GET["place_id"];
					//Save uploaded files to appropriate directory
					$photo_id = $this->addImages($place_id);

					//Now we need to tell our widget that the upload was succesfull
					//We do so, using the json structure defined in
					// https://github.com/blueimp/jQuery-File-Upload/wiki/Setup
					echo json_encode(array(array(
							"name" => $model->name,
							"type" => $model->mime_type,
							"size" => $model->size,
							"url" => $publicPath . $filename,
							//"thumbnail_url" => $publicPath . "thumbs/$filename",
							"delete_url" => $this->createUrl("upload", array(
								"_method" => "delete",
								"file" => $filename,
								"name" => $model->name,
								"place_id" => $place_id,
								"photo_id" => $photo_id
							)),
							"delete_type" => "POST"
							)));
				} else {
					//If the upload failed for some reason we log some data and let the widget know
					echo json_encode(array(
						array("error" => $model->getErrors('file'),
							)));
					Yii::log("XUploadAction: " . CVarDumper::dumpAsString($model->getErrors()), CLogger::LEVEL_ERROR, "xupload.actions.XUploadAction"
					);
				}
			} else {
				throw new CHttpException(500, "Could not upload file");
			}
		}
	}

	public function addImages($_place_id) {
		//If we have pending images
		if (Yii::app()->user->hasState('images')) {
			$userImages = Yii::app()->user->getState('images');
			//Resolve the final path for our images
			$path = Yii::app()->getBasePath() . "/../uploads/places/{$_place_id}/";
			//Create the folder and give permissions if it doesnt exists
			if (!is_dir($path)) {
				mkdir($path);
				chmod($path, 0777);
			}
			//Now lets create the corresponding models and move the files
			foreach ($userImages as $image) {
				if (is_file($image["path"])) {
					if (rename($image["path"], $path . $image["name"])) {
						chmod($path . $image["name"], 0777);
						$img = new PlacesPhotoModel( );
						$img->filename = $image["name"];
						$img->place_id = $_place_id;
						//$img->source = "/uploads/places/{$place_id}/" . $image["filename"];
						//$img->somemodel_id = $this->id;
						if (!$img->save()) {
							//Its always good to log something
							Yii::log("Could not save Image:\n" . CVarDumper::dumpAsString(
											$img->getErrors()), CLogger::LEVEL_ERROR);
							//this exception will rollback the transaction
							throw new Exception('Could not save Image');
						}
						$photo_id = $img->photo_id;
					}
				} else {
					//You can also throw an execption here to rollback the transaction
					Yii::log($image["path"] . " is not a file", CLogger::LEVEL_WARNING);
				}
			}
			//Clear the user's session
			Yii::app()->user->setState('images', null);
		}
		/**
		 * add refresh view "_places_photo"
		 * 
		 * if ($_place_id = (int) $_GET['place_id'] ? : null) {
			$PlacesModel = PlacesModel::model()->findByPk($_place_id);
			$PlacesModel->setScenario('formsubmit');
		}
		$this->renderPartial('_places_photos', array(
			'model' => $PlacesModel,
		));
		 */
		
		return $photo_id;
	}

	public function deleteImages($_place_id, $_name, $_photo_id) {
		$file = realpath(Yii::app()->getBasePath() . "/../uploads/places/{$_place_id}/") . "/" . $_name;
		if (is_file($file)) {
			unlink($file);
		} else {
			throw new Exception('No such file');
		}

		if (!$photo = PlacesPhotoModel::model()->findByPk($_photo_id)) {
			throw new CHttpException(500);
		}
		$photo->delete();
	}

}