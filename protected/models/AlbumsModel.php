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
			'author_id' => Yii::t('YcmModule.albums', 'Author id'),
			'title' => Yii::t('YcmModule.albums', 'Title'),
			'url_title' => Yii::t('YcmModule.albums', 'Url title'),
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
			//array('url_title', 'textField'),
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
			'open' => 'open',
			'closed' => 'closed'
		);
	}

	public function place_idChoices() {
		return CHtml::listData(
			PlacesDescModel::model()->findAll(), 'place_id', 'title'
		);
	}
	
	public function rules() {
		return array(
			array('status, title, place_id', 'required'),
			array('url_title, title', 'unique', 'attributeName' => 'url_title'),
			array('title, url_title, album_cover, place_id, albumEvent, album_date, status', 'safe'),
			array('url_title','ext.LocoTranslitFilter','translitAttribute'=>'title'),
			array('image', 'file', 'types'=> 'jpg, jpeg, png, gif','maxSize' => 1048576, 'allowEmpty' => true),
		);
	}
	
	public function beforeSave() {
		if ($this->getIsNewRecord()){
			$this->author_id = Yii::app()->user->id;
			$this->ip_address = Yii::app()->request->userHostAddress;
		
		}
		return parent::beforeSave();
	}
	
	public function relations() {
		return array(
			'author' => array(self::HAS_ONE, 'UsersModel', array('user_id' => 'author_id')),
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