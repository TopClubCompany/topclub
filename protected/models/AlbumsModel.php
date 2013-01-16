<?php

class AlbumsModel extends CActiveRecord {

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
			'album_id' => Yii::t('YcmModule.albums', 'album_id'),
			'author_id' => Yii::t('YcmModule.albums', 'author_id'),
			'title' => Yii::t('YcmModule.albums', 'title'),
			'url_title' => Yii::t('YcmModule.albums', 'url_title'),
			'place_id' => Yii::t('YcmModule.albums', 'place_id'),
			'album_cover' => Yii::t('YcmModule.albums', 'album_cover'),
			'albumEvent' => Yii::t('YcmModule.albums', 'albumEvent'),
			'album_date' => Yii::t('YcmModule.albums', 'album_date'),
			'status' => Yii::t('YcmModule.albums', 'status')
		);
	}
	
	public function attributeWidgets() {
		return array(
			array('title', 'textField'),
			array('url_title', 'textField'),
			array('place_id', 'dropDown'),
			array('album_cover', 'textField'),
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
	
	public function place_idChoices(){
		return CHtml::listData(
				PlacesModel::model()->findAll(), 
				'place_id', 
				'title');
	}

	public function rules() {
		return array(
			array('status','required'),
			array('url_title', 'unique', 'attributeName' => 'url_title'),
			array('title, url_title, place_id, album_cover, albumEvent, status', 'safe')/*,
			array('password, password_repeat', 'required', 'on' => array('formsubmit')),
			array('phone', 'match', 'pattern' => '/\d{12}/'),
			array('last_name, location', 'match', 'pattern' => '/[a-zа-я_-]/i')*/
		);
	}
	
	public function relations() {
		return array(
			'author' => array(self::HAS_ONE, 'UsersModel', array('user_id' => 'author_id')),
			'place_title' => array(self::HAS_ONE, 'PlacesModel', array('place_id' => 'place_id'))
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