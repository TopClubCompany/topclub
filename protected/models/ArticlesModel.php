<?php

class ArticlesModel extends CActiveRecord {
	public $image;

	/**
	 * 
	 * @param String $className
	 * @return Articles
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
	public function attributeLabels() {
		return array(
			'article_id' => Yii::t('YcmModule.articles', 'Article id'),
			'pub_cover' => Yii::t('YcmModule.articles', 'Article cover'),
			'title' => Yii::t('YcmModule.articles', 'Title'),
			'url' => Yii::t('YcmModule.articles', 'Url'),
			'pub_txt' => Yii::t('YcmModule.articles', 'Article text'),
			'sub_header' => Yii::t('YcmModule.articles', 'Sub header'),
			'status' => Yii::t('YcmModule.articles', 'Status'),
		);
	}

	public function attributeWidgets() {
		return array(
			array('title', 'textField'),
			array('image', 'file'),
			array('sub_header', 'textField'),
			array('pub_txt', 'wysiwyg'),
			array('status', 'dropDown'),
		);
	}

	public function statusChoices() {
		return array(
			'1' =>Yii::t('YcmModule.articles', 'Open'),
			'0' => Yii::t('YcmModule.articles', 'Closed')
		);
	}
	
	public function getStatus() {
		$status = $this->statusChoices();
		return $status[$this->status];
	}
	
	public function rules() {
		return array(
			array('title, sub_header, pub_txt', 'required'),
			array('url, title', 'unique', 'attributeName' => 'url'),
			array('url, pub_cover, status', 'safe'),
			array('url', 'ext.LocoTranslitFilter', 'translitAttribute' => 'title'),
			array('image', 'file', 'types' => 'jpg, jpeg, png, gif', 'maxSize' => 1048576, 'allowEmpty' => true),
		);
	}
	
	public function beforeSave() {
		if ($this->getIsNewRecord()) {
			$this->created_at = $this->updated_at = date('Y-d-m h:i:s');
			$this->created_by = $this->updated_by = Yii::app()->user->id;
			$this->ip_address = Yii::app()->request->userHostAddress;
		}
		return parent::beforeSave();
	}
	
	public function tableName() {
		return 'articles';
	}

	public function primaryKey() {
		return 'article_id';
	}

	public function search() {
		return new CActiveDataProvider($this);
	}

}
