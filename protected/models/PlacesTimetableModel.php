<?php

class PlacesTimetableModel extends CActiveRecord {

	/**
	 * 
	 * @param string $className
	 * @return PlacesTimetableModel
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
	
	public function rules() {
		return array(
			array('place_id, day, from, to, 24h', 'safe'),
		);
	}

	
	
	/*public function category_idChoices() {
		$language_id = LanguageModel::model()->find('code=:code', array(':code' => Yii::app()->language))->language_id;
		return CHtml::listData(
						PlacesCategoriesDescModel::model()->findAll('language_id=:language_id', array(':language_id' => $language_id)),
				"category_id", 
				'name'
		);;
	}*/

	/*public function statusChoices() {
		return array(
			'0' => Yii::t('YcmModule.places', 'Closed'),
			'1' => Yii::t('YcmModule.places', 'Open')
		);
	}*/

	/*public function relations() {
		$languageRelations = array();
		$languages = LanguageModel::model()->enabled()->findAll();
		foreach ($languages as $language) {
			$languageRelations[$language->code] = array(
				self::HAS_ONE,
				'PlacesDescModel',
				array('place_id' => 'place_id'),
				'condition' => 'language_id=:language_id',
				'params' => array(
					':language_id' => $language->language_id
				)
			);
		}

		return array_merge(array(
					'places_photo' => array(self::HAS_MANY, 'PlacesPhotoModel', array('place_id' => 'place_id')),
						), $languageRelations);
	}*/

	/*public function lang($lang = null) {
		if ($lang === null)
			$lang = Yii::app()->getLanguage();
		$this->getDbCriteria()->mergeWith(array(
			'with' => $lang
		));
		return $this;
	}*/

	public function tableName() {
		return 'places_timetable';
	}

	public function primaryKey() {
		return 'place_id';
	}

	public function search() {
		return new CActiveDataProvider($this);
	}
}