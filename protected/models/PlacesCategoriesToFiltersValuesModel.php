<?php

class PlacesCategoriesToFiltersValuesModel extends CActiveRecord {
	/**
	 * 
	 * @param String $className
	 * @return PlacesCategoriesToFiltersValues
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function rules() {
		 array('place_id, filter_id, value_id', 'safe');
	}
	
	public function tableName() {
		return 'places_categories_to_filters_values';
	}

	public function search() {
		return new CActiveDataProvider($this);
	}

}