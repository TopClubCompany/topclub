<?php

class FiltersValuesModel extends CActiveRecord {

	/**
	 * 
	 * @param type $className
	 * @return FiltersValuesModel
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'filters_values';
	}

	public function primaryKey() {
		return 'value_id';
	}

	public function attributeLabels() {
		return array(
			'value_id' => 'ID',
			'url' => 'URL',
			'filter_id' => Yii::t('YcmModule.filters', 'Filter'),
		);
	}

	public function attributeWidgets() {
		return array(
			array('url', 'textField'),
			array('filter_id', 'dropDown'),
		);
	}

	public function filter_idChoices() {
		return CHtml::listData(FiltersModel::model()->findAll(), 'filter_id', 'url');
	}

	public function rules() {
		return array(
			array('value_id, filter_id', 'safe'),
			array('url', 'required'),
			array('filter_id', 'required', on => 'add_filter_value')
		);
	}

	public function relations() {
		$languageRelations = array();
		$languages = LanguageModel::model()->enabled()->findAll();
		foreach ($languages as $language) {
			$languageRelations[$language->code] = array(
				self::HAS_ONE,
				'FiltersValuesDescModel',
				array('value_id' => 'value_id'),
				'condition' => 'language_id=:language_id',
				'params' => array(
					':language_id' => $language->language_id
				)
			);
		}
		
		return array_merge(array(
			'filter' => array(self::BELONGS_TO, 'FiltersModel', array('filter_id' => 'filter_id')),
		),	$languageRelations);
	}

	public function search() {
		$criteria = new CDbCriteria();
		if ($_GET['FiltersValuesModel']) {
			if ($filter_id = (int) $_GET['FiltersValuesModel']['filter_id'] ? : null) {
				$this->filter_id = $filter_id;
				$criteria->addCondition('filter_id=:filter_id');
				$criteria->params = array_merge($criteria->params, array(
					':filter_id' => $filter_id
				));
			}
		}
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria
		));
	}

	/*public function defaultScope() {
		if ($lang === null)
			$lang = Yii::app()->getLanguage();
		return array(
			'with' => $lang
		);
	}*/

	public function lang($lang = null) {
		if ($lang === null)
			$lang = Yii::app()->getLanguage();
		$this->getDbCriteria()->mergeWith(array(
			'with' => $lang
		));
		return $this;
	}

}
