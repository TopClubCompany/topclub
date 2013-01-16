<?php
class PlacesModel extends CActiveRecord {
	
	/**
	 * 
	 * @param string $className
	 * @return PlacesModel
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
	
	public function tableName() {
		return 'places';
	}
	
	public function primaryKey() {
		return 'place_id';
	}

	public function search() {
		return new CActiveDataProvider($this);
	}
}