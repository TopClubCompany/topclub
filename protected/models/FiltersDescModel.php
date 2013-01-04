<?php

class FiltersDescModel extends CActiveRecord {
	
	/**
	 * 
	 * @param type $className
	 * @return FiltersDescModel
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'filters_desc';
	}
	
	public function rules() {
		return array(
			array('description', 'safe'),
			array('filter_id, language_id, name', 'safe'),
		);
	}
	
	public function attributeLabels() {
		return array(
			'name' => Yii::t('YcmModule.filters', 'Filter name'),
			'description' => Yii::t('YcmModule.filters', 'Description'),
		);
	}

}