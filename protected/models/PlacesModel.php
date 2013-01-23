<?php

class PlacesModel extends CActiveRecord {

	public $address;

	/**
	 * 
	 * @param string $className
	 * @return PlacesModel
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function attributeLabels() {
		return array(
			'address' => Yii::t('YcmModule.places', 'Address'),
			'place_id' => Yii::t('YcmModule.places', 'Place id'),
			'url_title' => Yii::t('YcmModule.places', 'Url title'),
			'status' => Yii::t('YcmModule.places', 'Status'),
			'schedule' => Yii::t('YcmModule.places', 'Schedule'),
			'street_number' => Yii::t('YcmModule.places', 'Street number'),
			'phone' => Yii::t('YcmModule.places', 'Phone'),
			'phone2' => Yii::t('YcmModule.places', 'Phone2'),
			'admin_phone' => Yii::t('YcmModule.places', 'Admin phone'),
			'website' => Yii::t('YcmModule.places', 'Website'),
			'email' => Yii::t('YcmModule.places', 'Email'),
			'cost' => Yii::t('YcmModule.places', 'Cost'),
			'lat' => Yii::t('YcmModule.places', 'Lat'),
			'lng' => Yii::t('YcmModule.places', 'Lng'),
			'order_discount' => Yii::t('YcmModule.places', 'Order discount'),
			'order_discount_banket' => Yii::t('YcmModule.places', 'Order discount banket'),
			'closed' => Yii::t('YcmModule.places', 'Place closed ?'),
		);
	}

	public function rules() {
		return array(
			array('url_title, status, schedule, street_number, phones, lat, lng', 'required'),
			array('email, admin_phone, website, cost, order_discount, order_discount_banket, closed', 'safe'),
		);
	}

	public function attributeWidgets() {
		return array(
			//array('title', 'textField'),
			array('url_title', 'textField'),
			array('status', 'dropDown'),
			//array('name', 'textField'),
			array('schedule', 'textField'),
			//array('place_desc', 'wysiwyg'),
			//array('street', 'textField'),
			array('street_number', 'textField'),
			array('phone', 'textField'),
			array('phone2', 'textField'),
			array('admin_phone', 'textField'),
			array('url_title', 'textField'),
			array('website', 'textField'),
			array('email', 'textField'),
			array('cost', 'textField'),
			array('lat', 'textField'),
			array('lng', 'textField'),
			array('order_discount', 'textField'),
			array('order_discount_banket', 'textField'),
			//array('search_mistakes', 'textField'),
			array('closed', 'dropDown'),
		);
	}

	public function closedChoices() {
		return array(
			'0' => Yii::t('YcmModule.common', 'No'),
			'1' => Yii::t('YcmModule.common', 'Yes'),
		);
	}

	public function statusChoices() {
		return array(
			'0' => Yii::t('YcmModule.places', 'Closed'),
			'1' => Yii::t('YcmModule.places', 'Open')
		);
	}

	/* public function relations() {
	  return array(
	  'places_photo' => array(self::HAS_MANY, 'PlacesPhotoModel', array('place_id' => 'place_id'))
	  );
	  } */

	public function relations() {
		$languageRelations = array();
		$languages = LanguageModel::model()->enabled()->findAll();
		foreach ($languages as $language) {
			$languageRelations[$language->code] = array(
				self::HAS_ONE,
				'PlacesDescModel',
				array('place_id' => 'place_id'),
				'condition' => 'language_id=:language_id',
				'params' => array(
					':language_id' => $language->language_id
				)
			);
		}

		return array_merge(array(
					'places_photo' => array(self::HAS_MANY, 'PlacesPhotoModel', array('place_id' => 'place_id')),
						), $languageRelations);
	}

	public function lang($lang = null) {
		if ($lang === null)
			$lang = Yii::app()->getLanguage();
		$this->getDbCriteria()->mergeWith(array(
			'with' => $lang
		));
		return $this;
	}

	public function tableName() {
		return 'places';
	}

	public function primaryKey() {
		return 'place_id';
	}

	public function search() {
		/* $criteria = new CDbCriteria();
		  var_dump($_GET);die;
		  if ($_GET['PlacesModel']) {
		  if ($place_id = (int) $_GET['PlacesModel']['place_id'] ? : null) {
		  $this->place_id = $place_id;
		  $criteria->addCondition('place_id=:place_id');
		  $criteria->params = array_merge($criteria->params, array(
		  ':place_id' => $place_id
		  ));
		  }
		  }
		  return new CActiveDataProvider($this, array(
		  'criteria' => $criteria
		  )); */
		return new CActiveDataProvider($this);
	}

}