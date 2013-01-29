<?php

/**
 * Description of UploadAction
 *
 * @author tolyamba
 */
class UploadAction extends CAction {

	public $path;
	public $publicPath;
	public $folder;

	public function init() {
		if (!isset($this->folder)) {
			$this->folder = "tmp";
		}

		if (!isset($this->path)) {
			$this->path = realpath(Yii::app()->getBasePath() . "/../uploads/{$this->folder}") . "/";
		}

		if (!isset($this->publicPath)) {
			$this->publicPath = Yii::app()->getBaseUrl() . "/uploads/{$this->folder}/";
		}

		$this->createFolder($this->path);
	}

	public function run() {
		$this->init();

		$this->sendHeaders();
		//Here we check if we are deleting and uploaded file
		$this->handleDeleting() or $this->handleUploading();
	}

	protected function sendHeaders() {
		//This is for IE which doens't handle 'Content-type: application/json' correctly
		header('Vary: Accept');
		if (isset($_SERVER['HTTP_ACCEPT']) && (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
			header('Content-type: application/json');
		} else {
			header('Content-type: text/plain');
		}
	}

	public function handleUploading() {
		Yii::import("xupload.models.XUploadForm");
		//Here we define the paths where the files will be stored temporarily
		$ID = $_GET["ID"];
		$path = $this->path . $ID . "/";
		$publicPath = $this->publicPath . $ID . "/";
		
		$model = new XUploadForm;
		$model->file = CUploadedFile::getInstance($model, 'file');
		//We check that the file was successfully uploaded
		if ($model->file !== null) {
			//Grab some data
			$model->mime_type = $model->file->getType();
			$model->size = $model->file->getSize();
			$model->name = $model->file->getName();
			//$filename = md5(Yii::app()->user->id . microtime() . $model->name);
			//$filename .= "." . $model->file->getExtensionName();
			$filename = $model->name;
			if ($model->validate()) {
				$this->createFolder($path);
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


				$user_id = $_GET["user_id"];
				//Save uploaded files to appropriate directory
				$photo_id = $this->addImages($ID, $user_id);

				//Now we need to tell our widget that the upload was succesfull
				//We do so, using the json structure defined in
				// https://github.com/blueimp/jQuery-File-Upload/wiki/Setup

				echo json_encode(array(array(
						"name" => $model->name,
						"type" => $model->mime_type,
						"size" => $model->size,
						"url" => $publicPath . $filename,
						//"thumbnail_url" => $publicPath . "thumbs/$filename",
						"delete_url" => Yii::app()->createUrl("ycm/{$this->folder}/upload", array(
							"_method" => "delete",
							"file" => $filename,
							"name" => $model->name,
							"ID" => $ID,
							"photo_id" => $photo_id,
							"user_id" => $user_id
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

	public function addImages($_ID, $_user_id) {
		//If we have pending images
		if (Yii::app()->user->hasState('images')) {
			$userImages = Yii::app()->user->getState('images');
			//Resolve the final path for our images
			$path = Yii::app()->getBasePath() . "/../uploads/{$this->folder}/{$_ID}/";
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
						switch ($this->folder){
							case 'albums':
								$img = new PhotosModel( );
								$img->filename = $image["name"];
								$img->album_id = $_ID;
								$img->user_id = $_user_id;
								$img->ip_address = Yii::app()->request->userHostAddress;
								break;
							case 'places':
								$img = new PlacesPhotoModel( );
								$img->filename = $image["name"];
								$img->place_id = $_ID;
								break;
						}
						
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

		return $photo_id;
	}

	protected function handleDeleting() {
		if (isset($_GET["_method"]) && $_GET["_method"] == "delete") {
			$ID = $_GET["ID"];
			$name = $_GET["name"];
			$photo_id = $_GET["photo_id"];
			$this->deleteImages($ID, $name, $photo_id);
			echo json_encode(true);
			return true;
		}
		return false;
	}
	
	public function deleteImages($_ID, $_name, $_photo_id) {
		$file = realpath(Yii::app()->getBasePath() . "/../uploads/{$this->folder}/{$_ID}/") . "/" . $_name;
		if (is_file($file)) {
			unlink($file);
		} else {
			throw new Exception('No such file');
		}
		
		switch ($this->folder){
			case 'albums':
				if (!$photo = PhotosModel::model()->findByPk($_photo_id)) {
					throw new CHttpException(500);
				}
				break;
			case 'places':
				if (!$photo = PlacesPhotoModel::model()->findByPk($_photo_id)) {
					throw new CHttpException(500);
				}
				break;
		}
		$photo->delete();
	}
	
	public function createFolder($path) {
		if (!is_dir($path)) {
			mkdir($path, 0777, true);
			chmod($path, 0777);
			//throw new CHttpException(500, "{$this->path} does not exists.");
		} else if (!is_writable($path)) {
			chmod($path, 0777);
			//throw new CHttpException(500, "{$this->path} is not writable.");
		}
	}

}