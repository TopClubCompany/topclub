<?php

class PlacesController extends AdminController {

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
			Yii::t('YcmModule.places', 'places')
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
			Yii::t('YcmModule.places', 'places') => array('places/index'),
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
		$this->render('edit', array(
			'model' => $PlacesModel
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
		Yii::import( "xupload.models.XUploadForm" );
		//Here we define the paths where the files will be stored temporarily
		$path = realpath( Yii::app( )->getBasePath( )."/../uploads/tmp/" )."/";
		$publicPath = Yii::app( )->getBaseUrl( )."/uploads/tmp/";

		//This is for IE which doens't handle 'Content-type: application/json' correctly
		header( 'Vary: Accept' );
		if( isset( $_SERVER['HTTP_ACCEPT'] ) 
			&& (strpos( $_SERVER['HTTP_ACCEPT'], 'application/json' ) !== false) ) {
			header( 'Content-type: application/json' );
		} else {
			header( 'Content-type: text/plain' );
		}

		//Here we check if we are deleting and uploaded file
		if( isset( $_GET["_method"] ) ) {
			if( $_GET["_method"] == "delete" ) {
				if( $_GET["file"][0] !== '.' ) {
					$file = $path.$_GET["file"];
					if( is_file( $file ) ) {
						unlink( $file );
					}
				}
				echo json_encode( true );
			}
		} else {
			
			$model = new XUploadForm;
			//var_dump($model);
			$model->file = CUploadedFile::getInstance( $model, 'file' );
			//$model->file = $_FILES["PlacesModel"];
			var_dump($_FILES);
			var_dump($model);die;
			//We check that the file was successfully uploaded
			if( $model->file !== null ) {
				//Grab some data
				$model->mime_type = $model->file->getType( );
				$model->size = $model->file->getSize( );
				$model->name = $model->file->getName( );
				//(optional) Generate a random name for our file
				$filename = md5( Yii::app( )->user->id.microtime( ).$model->name);
				$filename .= ".".$model->file->getExtensionName( );
				if( $model->validate( ) ) {
					//Move our file to our temporary dir
					$model->file->saveAs( $path.$filename );
					chmod( $path.$filename, 0777 );
					//here you can also generate the image versions you need 
					//using something like PHPThumb


					//Now we need to save this path to the user's session
					var_dump($model);
					if( Yii::app( )->user->hasState( 'images' ) ) {
						$userImages = Yii::app( )->user->getState( 'images' );
					} else {
						$userImages = array();
					}
					 $userImages[] = array(
						"path" => $path.$filename,
						//the same file or a thumb version that you generated
						"thumb" => $path.$filename,
						"filename" => $filename,
						'size' => $model->size,
						'mime' => $model->mime_type,
						'name' => $model->name,
					);
					Yii::app( )->user->setState( 'images', $userImages );

					//Now we need to tell our widget that the upload was succesfull
					//We do so, using the json structure defined in
					// https://github.com/blueimp/jQuery-File-Upload/wiki/Setup
					echo json_encode( array( array(
							"name" => $model->name,
							"type" => $model->mime_type,
							"size" => $model->size,
							"url" => $publicPath.$filename,
							"thumbnail_url" => $publicPath."thumbs/$filename",
							"delete_url" => $this->createUrl( "upload", array(
								"_method" => "delete",
								"file" => $filename
							) ),
							"delete_type" => "POST"
						) ) );
				} else {
					//If the upload failed for some reason we log some data and let the widget know
					echo json_encode( array( 
						array( "error" => $model->getErrors( 'file' ),
					) ) );
					Yii::log( "XUploadAction: ".CVarDumper::dumpAsString( $model->getErrors( ) ),
						CLogger::LEVEL_ERROR, "xupload.actions.XUploadAction" 
					);
				}
			} else {
				throw new CHttpException( 500, "Could not upload file" );
			}
		}
	}
}