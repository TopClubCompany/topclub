<?php

class EventsModel extends CActiveRecord {
	/**
	 * 
	 * @param String $className
	 * @return Events
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
	
	public function tableName() {
		return 'events';
	}

	public function primaryKey() {
		return 'event_id';
	}

	public function search() {
		return new CActiveDataProvider($this);
	}

}