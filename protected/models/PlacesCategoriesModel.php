<?php

class PlacesCategoriesModel extends CActiveRecord {
	public $filters;
	/**
	 * 
	 * @param String $className
	 * @return PlacesCategories
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
	
	public function attributeLabels() {
		return array(
			'url' => 'URL',
			'category_id' => 'ID',
			'filters' => Yii::t('YcmModule.placesCategories', 'Filters'),
		);
	}
		
	public function relations() {
		$languages = LanguageModel::model()->enabled()->findAll();
		$_lang_relations = array();
		foreach ($languages as $language) {
			$_lang_relations[$language->code] = array(
				self::HAS_ONE,
				'PlacesCategoriesDescModel',
				array(
					'category_id' => 'category_id'
				),
				'condition' => 'language_id=:language_id',
				'params' => array(
					':language_id' => $language->language_id
				)
			);
		}
		return array_merge(array(
			'filters' => array(self::HAS_MANY, 'PlacesCategoriesToFiltersModel', array('category_id' => 'category_id')),
		), $_lang_relations);
	}
	
	public function tableName() {
		return 'places_categories';
	}

	public function primaryKey() {
		return 'category_id';
	}
	
	public function lang($lang = null) {
		if ($lang === null)
			$lang = Yii::app()->getLanguage();
		$this->getDbCriteria()->mergeWith(array(
			'with' => $lang
		));
		return $this;
	}
	
	public function rules() {
		return array(
			array('url', 'unique', 'attributeName' => 'url'),
		);
	}
	
	public function search() {
		return new CActiveDataProvider($this);
	}

}