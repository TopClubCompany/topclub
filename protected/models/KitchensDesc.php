<?php

class KitchensDesc extends CActiveRecord {

	public $kitchen_id,
			$language_id,
			$name,
			$description;

	public function tableName() {
		return 'kitchens_desc';
	}

	public function reules() {
		return array(
			array('kitchen_id,language_id,name,description', 'safe')
		);
	}

}