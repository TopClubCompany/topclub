<?php

class AlbumsModel extends CActiveRecord {

	public $image;

	/**
	 * 
	 * @param String $className
	 * @return Album
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function attributeLabels() {
		return array(
			'album_id' => Yii::t('YcmModule.albums', 'Album id'),
			'user_id' => Yii::t('YcmModule.albums', 'User id'),
			'title' => Yii::t('YcmModule.albums', 'Title'),
			'url' => Yii::t('YcmModule.albums', 'Url title'),
			'place_id' => Yii::t('YcmModule.albums', 'Place id'),
			'album_cover' => Yii::t('YcmModule.albums', 'Album cover'),
			'albumEvent' => Yii::t('YcmModule.albums', 'Album event'),
			'album_date' => Yii::t('YcmModule.albums', 'Album date'),
			'status' => Yii::t('YcmModule.albums', 'Status'),
			'image' => Yii::t('YcmModule.albums', 'Upload cover')
		);
	}

	public function attributeWidgets() {
		return array(
			array('title', 'textField'),
			array('place_id', 'dropDown'),
			array('album_cover', 'textField'),
			array('image', 'file'),
			array('albumEvent', 'textField'),
			array('album_date', 'date'),
			array('status', 'dropDown'),
		);
	}

	public function statusChoices() {
		return array(
			'1' =>Yii::t('YcmModule.albums', 'Open'),
			'0' => Yii::t('YcmModule.albums', 'Closed')
		);
	}
	
	public function getStatus() {
		$status = $this->statusChoices();
		return $status[$this->status];
	}
	
	public function place_idChoices() {
		$language_id = LanguageModel::model()->find('code=:code', array(':code' => Yii::app()->language))->language_id;
		return CHtml::listData(
						PlacesDescModel::model()->findAll('language_id=:language_id', array(':language_id' => $language_id)), 'place_id', 'title'
		);
	}

	public function rules() {
		return array(
			array('status, title, place_id', 'required'),
			array('url, title', 'unique', 'attributeName' => 'url'),
			array('title, url, album_cover, place_id, albumEvent, album_date, status', 'safe'),
			array('url', 'ext.LocoTranslitFilter', 'translitAttribute' => 'title'),
			array('image', 'file', 'types' => 'jpg, jpeg, png, gif', 'maxSize' => 1048576, 'allowEmpty' => true),
		);
	}

	public function beforeSave() {
		if ($this->getIsNewRecord()) {
			$this->user_id = Yii::app()->user->id;
			$this->ip_address = Yii::app()->request->userHostAddress;
		}
		return parent::beforeSave();
	}

	public function afterDelete() {
		$album_id = $_GET["album_id"];
		$path = realpath(Yii::app()->getBasePath() . "/../uploads/albums/{$album_id}/");
		$this->removeDir($path);
		parent::afterDelete();
	}

	public function removeDir($path) {
		if (file_exists($path) && is_dir($path)) {
			$dirHandle = opendir($path);
			while (false !== ($file = readdir($dirHandle))) {
				if ($file != '.' && $file != '..') {// исключаем папки с назварием '.' и '..' 
					$tmpPath = $path . '/' . $file;
					chmod($tmpPath, 0777);

					if (is_dir($tmpPath)) {  // если папка
						RemoveDir($tmpPath);
					} else {
						if (file_exists($tmpPath)) {
							// удаляем файл 
							unlink($tmpPath);
						}
					}
				}
			}
			closedir($dirHandle);
			// удаляем текущую папку
			if (file_exists($path)) {
				rmdir($path);
			}
		} else {
			echo "Удаляемой папки не существует или это файл!";
		}
	}

	 /*public function removeDir($path) {
		if (is_file($path)) {
		@unlink($path);
		} else {
		array_map($this->removeDir($path), glob('/*')) == @rmdir($path);
		}
		@rmdir($path);
	  } */

	public function relations() {
		return array(
			'author' => array(self::HAS_ONE, 'UsersModel', array('user_id' => 'user_id')),
			'place_title' => array(self::HAS_ONE, 'PlacesDescModel', array('place_id' => 'place_id'))
		);
	}

	public function tableName() {
		return 'albums';
	}

	public function primaryKey() {
		return 'album_id';
	}

	public function search() {
		return new CActiveDataProvider($this);
	}

}