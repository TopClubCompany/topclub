<?php

class PlacesDescModel extends CActiveRecord {
	
	/**
	 * 
	 * @param type $className
	 * @return PlacesDescModel
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'places_desc';
	}
	
	public function rules() {
		return array(
			array('place_id, language_id, title, name, place_desc, street, place_orientir, search_mistakes', 'safe'),
		);
	}
	
	public function primaryKey() {
		return 'place_id';
	}
	
	public function attributeLabels() {
		return array(
			'title' => Yii::t('YcmModule.places', 'Title'),
			'name' => Yii::t('YcmModule.places', 'Name'),
			'place_desc' => Yii::t('YcmModule.places', 'Place description'),
			'street' => Yii::t('YcmModule.places', 'Street'),
			'place_orientir' => Yii::t('YcmModule.places', 'Place reference point'),
			'search_mistakes' => Yii::t('YcmModule.places', 'Search mistakes'),
		);
	}
	
	public function lang($lang = null) {
		if ($lang === null)
			$lang = Yii::app()->getLanguage();
		$this->getDbCriteria()->mergeWith(array(
			'with' => $lang
		));
		return $this;
	}
}