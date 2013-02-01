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