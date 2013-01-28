<?php

class PlacesCategoriesToFiltersModel extends CActiveRecord {
	/**
	 * 
	 * @param String $className
	 * @return PlacesCategoriesToFilters
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function rules() {
		 array('category_id, filter_id', 'safe');
	}
	
	public function tableName() {
		return 'places_categories_to_filters';
	}

	public function search() {
		return new CActiveDataProvider($this);
	}

}