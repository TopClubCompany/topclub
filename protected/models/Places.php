<?php
class Places extends CActiveRecord {
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