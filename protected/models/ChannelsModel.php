<?php

class ChannelsModel extends CActiveRecord {
	/**
	 * 
	 * @param String $className
	 * @return Channels
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
	
	public function tableName() {
		return 'channels';
	}

	public function primaryKey() {
		return 'channel_id';
	}

	public function search() {
		return new CActiveDataProvider($this);
	}

}