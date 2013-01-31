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
	
	public function behaviors() {
		return array(
			'CTimestampBehavior' => array(
				'class' => 'system.zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'created_at',
				'updateAttribute' => 'updated_at',
			),
			'OwnerBehaviour' => array(
				'class' => 'ycm.behaviors.OwnerBehavior'
			)
		);
	}

	public function attributeLabels() {
		return array(
			'place_id' => Yii::t('YcmModule.places', 'Place id'),
			'category_id' => Yii::t('YcmModule.places', 'Category id'),
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
			'phones' => self::t('Phones')
		);
	}

	public function rules() {
		return array(
			array('url, status, schedule, street_number, phones', 'required'),
			array('category_id, email, admin_phone, website, cost, order_discount, order_discount_banket, closed, lat, lng', 'safe'),
		);
	}

	public function attributeWidgets() {
		return array(
			array('category_id', 'dropDown'),
			array('url_title', 'textField'),
			array('status', 'dropDown'),
			array('schedule', 'textField'),
			array('street_number', 'textField'),
			array('phone', 'textField'),
			array('phone2', 'textField'),
			array('admin_phone', 'textField'),
			array('url', 'textField'),
			array('website', 'textField'),
			array('email', 'textField'),
			array('cost', 'textField'),
			array('lat', 'textField'),
			array('lng', 'textField'),
			array('order_discount', 'textField'),
			array('order_discount_banket', 'textField'),
			array('closed', 'dropDown'),
		);
	}

	public function closedChoices() {
		return array(
			'0' => Yii::t('YcmModule.common', 'No'),
			'1' => Yii::t('YcmModule.common', 'Yes'),
		);
	}
	
	public function category_idChoices() {
		$language_id = LanguageModel::model()->find('code=:code', array(':code' => Yii::app()->language))->language_id;
		return CHtml::listData(
						PlacesCategoriesDescModel::model()->findAll('language_id=:language_id', array(':language_id' => $language_id)),
				"category_id", 
				'name'
		);;
	}

	public function statusChoices() {
		return array(
			'0' => Yii::t('YcmModule.places', 'Closed'),
			'1' => Yii::t('YcmModule.places', 'Open')
		);
	}

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
		return new CActiveDataProvider($this);
	}
	
	public function t($translate) {
		return Yii::t('YcmModule.' . self::tableName(), $translate);
	}

}