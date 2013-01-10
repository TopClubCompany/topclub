<?php

class FiltersValuesDescModel extends CActiveRecord {

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

}