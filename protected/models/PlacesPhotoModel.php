<?php

class PlacesPhotoModel extends CActiveRecord {

	/**
	 * 
	 * @param string $className
	 * @return PlacesPhotoModel
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'places_photo';
	}

	public function primaryKey() {
		return 'photo_id';
	}

	public function search() {
		return new CActiveDataProvider($this);
	}
	
	public function rules() {
		return array(
			array('photo_id, place_id, filename', 'safe'),
		);
	}

}