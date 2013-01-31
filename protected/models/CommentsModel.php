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

	public function afterFind() {
		$md = $this->getMetaData();
		switch ($this->type) {
			case 'articles':
				$entryModel = 'ArticlesModel';
				$entry_model_pk = 'article_id';
				break;
			case 'events':
				$entryModel = 'EventsModel';
				$entry_model_pk = 'event_id';
				break;
			case 'photos':
				$entryModel = 'PhotosModel';
				$entry_model_pk = 'photo_id';
				break;
			case 'albums':
				$entryModel = 'AlbumsModel';
				$entry_model_pk = 'album_id';
				break;

			case 'places':
			default:
				$entryModel = 'PlacesDescModel';
				$entry_model_pk = 'place_id';
				break;
		}
		$md->addRelation('entry', array(
			self::BELONGS_TO,
			$entryModel,
			array('entry_id' => $entry_model_pk)
		));
		return parent::afterFind();
	}

	public function relations() {
		return array(
			'user' => array(self::HAS_ONE, 'UsersModel', array('user_id' => 'user_id')),
			'language' => array(self::HAS_ONE, 'LanguageModel', array('language_id' => 'language_id')),
		);
	}

	public function attributeLabels() {
		return array(
			'comment_id' => Yii::t('YcmModule.comments', 'Comment id'),
			'entry_id' => Yii::t('YcmModule.comments', 'Entry id'),
			'type' => Yii::t('YcmModule.comments', 'Type'),
			'language_id' => Yii::t('YcmModule.comments', 'Language id'),
			'user_id' => Yii::t('YcmModule.comments', 'User id'),
			'comment' => Yii::t('YcmModule.comments', 'Comment'),
			'comment_date' => Yii::t('YcmModule.comments', 'Comment date'),
			'status' => Yii::t('YcmModule.comments', 'Status'),
		);
	}

	public function attributeWidgets() {
		return array(
			array('comment', 'textArea'),
			array('status', 'dropDown'),
			array('language_id', 'dropDown'),
		);
	}

	public function statusChoices() {
		return array(
			'1' => Yii::t('YcmModule.comments', 'Open'),
			'0' => Yii::t('YcmModule.comments', 'Closed')
		);
	}

	public function language_idChoices() {
		return CHtml::listData(
			LanguageModel::model()->enabled()->findAll(), 'language_id', 'name'
		);
	}

	public function typeChoices() {
		return array(
			"places" => Yii::t('YcmModule.comments', 'Places'),
			"articles" => Yii::t('YcmModule.comments', 'Articles'),
			"events" => Yii::t('YcmModule.comments', 'Events'),
			"photos" => Yii::t('YcmModule.comments', 'Photos'),
			"albums" => Yii::t('YcmModule.comments', 'Albums')
		);
	}

	public function getTypeChoice() {
		$typeChoices = $this->typeChoices();
		return $typeChoices[$this->type];
	}

	public function getStatus() {
		$status = $this->statusChoices();
		return $status[$this->status];
	}

	public function rules() {
		return array(
			array('place_id, language_id, channel_id, user_id, comment, ip_address, comment_date, status', 'safe'),
			array('status, language_id', 'required'),
		);
	}

	/* public function beforeSave() {
	  if ($this->getIsNewRecord()){
	  $this->author_id = Yii::app()->user->id;
	  $this->ip_address = Yii::app()->request->userHostAddress;

	  }
	  return parent::beforeSave();
	  } */

	public function tableName() {
		return 'comments';
	}

	public function primaryKey() {
		return 'comment_id';
	}

	public function search() {
		$criteria = new CDbCriteria;
		if ($_GET['CommentsModel']) {
			$this->attributes = $_GET['CommentsModel'];
			if ($comment_id = (int) $_GET['CommentsModel']['comment_id'] ? : null) {
				$criteria->addCondition('comment_id=:comment_id');
				$criteria->params = array_merge($criteria->params, array(
					':comment_id' => $comment_id
				));
				//$criteria->compare('comment_id', '=:'.$comment_id);
			}
			if($this->type = $type = $_GET['CommentsModel']['type'] ?: null){
				$criteria->addCondition('type=:type');
				$criteria->params = array_merge($criteria->params, array(
					':type' => $type
				));
			}
			if($language_id = $_GET['CommentsModel']['language_id'] ? : null){
				$criteria->addCondition('language_id=:language_id');
				$criteria->params = array_merge($criteria->params, array(
					':language_id' => $language_id
				));
			}
			if($_GET['CommentsModel']['status'] !== ""){
				$status = $_GET['CommentsModel']['status'];
				$criteria->addCondition('status=:status');
				$criteria->params = array_merge($criteria->params, array(
					':status' => $status
				));
			}
			/*if($comment = $_GET['CommentsModel']['comment'] ? : null){
				$criteria->addCondition('comment LIKE "%:comment%"');
				$criteria->params = array_merge($criteria->params, array(
					':comment' => $comment
				));
			}*/
		}
		
		if($place_id = $_GET["place_id"]){
			$criteria->addCondition('entry_id=:entry_id');
				$criteria->params = array_merge($criteria->params, array(
					':entry_id' => $place_id
				));
		}
		return new CActiveDataProvider($this, array(
					'criteria' => $criteria
		));
	}

}