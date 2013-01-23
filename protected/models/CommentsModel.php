<?php

class CommentsModel extends CActiveRecord {
	/**
	 * 
	 * @param String $className
	 * @return Comments
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
	
	public function relations() {
		return array(
			'author' => array(self::HAS_ONE, 'UsersModel', array('user_id' => 'user_id')),
			'place_title' => array(self::HAS_ONE, 'PlacesDescModel', array('place_id' => 'place_id')),
			'language' => array(self::HAS_ONE, 'LanguageModel', array('language_id' => 'language_id')),
			'channel' => array(self::HAS_ONE, 'ChannelsModel', array('channel_id' => 'channel_id')),
		);
	}
	
	public function attributeLabels() {
		return array(
			'comment_id' => Yii::t('YcmModule.comments', 'Comment id'),
			'place_id' => Yii::t('YcmModule.comments', 'Place id'),
			'channel_id' => Yii::t('YcmModule.comments', 'Channel'),
			'language_id' => Yii::t('YcmModule.comments', 'Language id'),
			'user_id' => Yii::t('YcmModule.comments', 'User id'),
			'comment' => Yii::t('YcmModule.comments', 'Comment'),
			'comment_date' => Yii::t('YcmModule.comments', 'Comment date'),
			'status' => Yii::t('YcmModule.comments', 'Status'),
		);
	}
	
	public function attributeWidgets() {
		return array(
			array('channel_id', 'dropDown'),
			array('place_id', 'dropDown'),
			array('comment', 'textArea'),
			array('status', 'dropDown'),
			array('language_id', 'dropDown'),
		);
	}
	
	public function statusChoices() {
		return array(
			'1' => 'open',
			'0' => 'closed'
		);
	}

	public function place_idChoices() {
		return CHtml::listData(
			PlacesDescModel::model()->findAll(), 'place_id', 'title'
		);
	}
	
	public function language_idChoices() {
		return CHtml::listData(
			LanguageModel::model()->enabled()->findAll(), 'language_id', 'name'
		);
	}
	
	public function channel_idChoices() {
		return CHtml::listData(
			ChannelsModel::model()->findAll(), 'channel_id', 'channel_title'
		);
	}
	
	public function rules() {
		return array(
			array('place_id, language_id, channel_id, user_id, comment, ip_address, comment_date, status', 'safe'),
			array('status, language_id', 'required'),
		);
	}
	
	/*public function beforeSave() {
		if ($this->getIsNewRecord()){
			$this->author_id = Yii::app()->user->id;
			$this->ip_address = Yii::app()->request->userHostAddress;
		
		}
		return parent::beforeSave();
	}*/
	
	

	public function tableName() {
		return 'comments';
	}

	public function primaryKey() {
		return 'comment_id';
	}

	public function search() {
		return new CActiveDataProvider($this);
	}

}