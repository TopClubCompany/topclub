<?php

class PlacesCategoriesDescModel extends CActiveRecord {
	/**
	 * 
	 * @param String $className
	 * @return PlacesCategoriesDesc
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'places_categories_desc';
	}

	public function rules() {
		return array(
			array('category_id, language_id, name, description', 'safe'),
		);
	}
	
	public function attributeLabels() {
		return array(
			'name' => Yii::t('YcmModule.placesCategories', 'Category place name'),
			'description' => Yii::t('YcmModule.placesCategories', 'Description'),
		);
	}

	public function search() {
		return new CActiveDataProvider($this);
	}

}