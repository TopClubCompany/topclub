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
			Yii::t('YcmModule.albums', 'Albums')
		);
		$render = $_GET['ajax'] ? 'renderPartial' : 'render';
		$this->$render('index');
	}

	public function actionAdd() {
		$this->actionEdit();
	}

	public function actionEdit() {

		$this->breadcrumbs = array(
			Yii::t('YcmModule.albums', 'Albums') => array('albums/index'),
		);

		if ($album_id = (int) $_GET['album_id'] ? : null) {
			$AlbumsModel = AlbumsModel::model()->findByPk($album_id);
			$AlbumsModel->setScenario('formupdate');
			$this->breadcrumbs = array_merge($this->breadcrumbs, array(
				Yii::t('YcmModule.albums', 'Edit album')
			));
		} else {
			$AlbumsModel = new AlbumsModel('formupdate');
			$this->breadcrumbs = array_merge($this->breadcrumbs, array(
				Yii::t('YcmModule.albums', 'Add album')
			));
		}
		if ($_POST['AlbumsModel']) {
			$AlbumsModel->attributes = $_POST['AlbumsModel'];
			if ($AlbumsModel->validate()) {
				if ($image = CUploadedFile::getInstance(AlbumsModel::model(), 'image')) {
					$extName = $image->getExtensionName();
					$path = Yii::app()->getBasePath() . "/../uploads/albums/$album_id/";
					$filename = $AlbumsModel->url_title."_cover.".$extName;
					
					if (!is_dir($path)) {
						mkdir($path);
						chmod($path, 0777);
					}
					
					if (is_file($image->getTempName())) {
						if (rename($image->getTempName(), $path . $filename)) {
							chmod($path . $filename, 0777);
							$AlbumsModel->album_cover = $filename;
							$AlbumsModel->save(false);
						}
					}
					$AlbumsModel->save(false);
					if ($_POST['_save']) {
						$redirect = array('albums/index');
					} else if ($_POST["_continue"]) {
						$redirect = array('albums/edit', 'album_id' => $AlbumsModel->album_id);
					} else if ($_POST['_addanother']) {
						$redirect = array('albums/add');
					}
					$this->redirect($redirect);
				}
			}
		}
		$this->render('edit', array(
			'model' => $AlbumsModel
		));
	}

	public function actionDelete() {
		if (!$album_id = (int) $_GET['album_id'] ? : null) {
			throw new CHttpException(404);
		}
		if (!$AlbumsModel = AlbumsModel::model()->findByPk($album_id)) {
			throw new CHttpException(404);
		}
		$AlbumsModel->delete();
		if (!$_GET['ajax'])
			$this->redirect(array('Filters/index'));
	}

	public function actionShow() {
		if ($album_id = (int) $_GET['album_id'] ? : null) {
			//count photos
			$n = PhotosModel::model()->count('album_id=:album_id', array(':album_id' => $album_id));

			$data = AlbumsModel::model()->findByAttributes(array('album_id' => $album_id))->attributes;
			$author = UsersModel::model()->find('user_id=:user_id', array(':user_id' => $data["author_id"]))->attributes;
			//breadcrumbs
			$this->breadcrumbs = array(
				Yii::t('YcmModule.albums', 'Albums') => array('albums/index'),
				Yii::t('YcmModule.albums', $data["title"]) => array('albums/edit', "album_id" => $album_id),
				Yii::t('YcmModule.albums', 'Photos from album: {name}, Add album: {author}', array('{name}' => $data["title"], '{author}' => $author["first_name"] . " " . $author["last_name"])),
			);

			//buttons
			$this->buttons = array(
				array(
					'buttonType' => 'submit',
					'label' => Yii::t('YcmModule.ycm', 'Update'),
					'url' => array(Yii::app()->controller->id . '/edit'),
					'htmlOptions' => array('name' => '_update_album', 'value' => '1', 'style' => 'margin-left:10px;')
				)
			);

			if ($_POST['_update_album']) {
				$this->ordering($_GET["album_id"]);
			}
			Yii::import("xupload.models.XUploadForm");
			$upload_photos = new XUploadForm;
			$this->render('show', array(
				'upload_photos' => $upload_photos,
				'count_photos' => $n,
				'model' => PhotosModel::model(),
				'author_id' => $data["author_id"],
				'url_title' => $url_title
			));
		} else {
			$this->redirect('albums/index');
		}
	}

	public function actionDeleteImage() {
		if ($photo_id = (int) $_GET['photo_id'] ? : null) {
			if (!$image = PhotosModel::model()->findByPk($photo_id)) {
				throw new CHttpException(404);
			}
			$file = realpath(Yii::app()->getBasePath() . "/../uploads/albums/{$image->album_id}/") . "/" . $image->photoPath;
			if (is_file($file)) {
				unlink($file);
			} /* else {
			  throw new Exception('No such file');
			  } */
			//delete record from db
			if ($image->delete())
				$this->ordering($image->album_id);
		} else {
			throw new CHttpException(404);
		}
		if (!$_GET['ajax'])
			$this->redirect(array('places/index'));
	}

	public function ordering($_album_id) {
		$data = PhotosModel::model()->findAll('album_id=:album_id', array(':album_id' => $_album_id));
		$album = AlbumsModel::model()->findByAttributes(array('album_id' => $_album_id))->attributes;
		$url_title_album = $album["url_title"];
		$i = 1;
		
		foreach ($data as $photos) {
			$PhotosModel = PhotosModel::model()->find('photo_id=:photo_id', array(':photo_id' => $photos->attributes["photo_id"]));
			if($i < 10)
				$c = "000".$i;
			else if($i < 100)
				$c = "00".$i;
			else if ($i < 1000)
				$c = "0".$i;
			$file = realpath(Yii::app()->getBasePath() . "/../uploads/albums/{$_album_id}/") . "/" . $PhotosModel->photoPath;
			//get type of image
			preg_match("/(jpg|jpeg|png|gif)/", $PhotosModel->photoPath, $type_match);
			$type = $type_match[0];
			$new_file = realpath(Yii::app()->getBasePath() . 
					"/../uploads/albums/{$_album_id}") . "/". $url_title_album."_".$c.".".$type;
			$new_PhotoPath = $url_title_album."_".$c.".".$type;
			if (is_file($file)) {
				if (rename($file, $new_file)) {
					chmod($new_file, 0777);
					$PhotosModel->photoPath = $new_PhotoPath;
				}
			}
			
			$PhotosModel->title = "Фото " . $i;
			$PhotosModel->url_title = "photo_" . $photos->attributes["photo_id"];
			$PhotosModel->save();
			$i++;
		}
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
				$album_id = $_GET["album_id"];
				$photo_id = $_GET["photo_id"];
				$this->deleteImages($album_id, $name, $photo_id);
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

					$album_id = $_GET["album_id"];
					$author_id = $_GET["author_id"];
					//Save uploaded files to appropriate directory
					$photo_id = $this->addImages($album_id, $author_id);

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
								"album_id" => $album_id,
								"photo_id" => $photo_id,
								"author_id" => $author_id
							)),
							"delete_type" => "POST"
						)
					));
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

	public function addImages($_album_id, $_author_id) {
		//If we have pending images
		if (Yii::app()->user->hasState('images')) {
			$userImages = Yii::app()->user->getState('images');
			//Resolve the final path for our images
			$path = Yii::app()->getBasePath() . "/../uploads/albums/{$_album_id}/";
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
						$img = new PhotosModel( );
						$img->photoPath = $image["name"];
						$img->album_id = $_album_id;
						$img->author_id = $_author_id;
						$img->ip_address = Yii::app()->request->userHostAddress;

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

	public function deleteImages($_album_id, $_name, $_photo_id) {
		$file = realpath(Yii::app()->getBasePath() . "/../uploads/albums/{$_album_id}/") . "/" . $_name;
		if (is_file($file)) {
			unlink($file);
		} else {
			throw new Exception('No such file');
		}

		if (!$photo = PhotosModel::model()->findByPk($_photo_id)) {
			throw new CHttpException(500);
		}
		$photo->delete();
	}

}