<?php

class FiltersModel extends CActiveRecord {
	
	/**
	 * 
	 * @param string $className
	 * @return FiltersModel
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'filters';
	}

	public function primaryKey() {
		return 'filter_id';
	}
	
	public function attributeLabels() {
		return array(
			'url' => 'URL',
			'filter_id' => 'ID',
		);
	}
	
	public function relations() {
		$languages = LanguageModel::model()->enabled()->findAll();
		$_lang_relations = array();
		foreach ($languages as $language) {
			$_lang_relations[$language->code] = array(
				self::HAS_ONE,
				'FiltersDescModel',
				array(
					'filter_id' => 'filter_id'
				),
				'condition' => 'language_id=:language_id',
				'params' => array(
					':language_id' => $language->language_id
				)
			);
		}
		return array_merge(array(), $_lang_relations);
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