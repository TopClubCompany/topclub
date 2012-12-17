<?php

class KitchensDesc extends CActiveRecord {
	
	/**
	 * 
	 * @return KitchensDesc
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'kitchens_desc';
	}

	public function rules() {
		return array(
			array('kitchen_id,language_id,name,description', 'safe')
		);
	}

	public function attributeWidgets() {
		return array(
			array('language_id', 'hidden'),
			array('name', 'textField'),
			array('description', 'wysiwyg'),
		);
	}

}