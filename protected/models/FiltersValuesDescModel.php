<?php

class FiltersValuesDescModel extends CActiveRecord {
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
	
	public function tableName() {
		return 'filters_values_desc';
	}
	
	public function primaryKey() {
		return 'value_id';
	}

	public function rules() {
		return array(
			array('value_id,language_id,name,description', 'safe'),
		);
	}
		
	public function attributeLabels() {
		return array(
			'name' => Yii::t('YcmModule.filters', 'Filter name'),
			'description' => Yii::t('YcmModule.filters', 'Description'),
		);
	}

}