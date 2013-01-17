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
			'place_id' => Yii::t('YcmModule.places', 'place_id'),
			'title' => Yii::t('YcmModule.places', 'title'),
			'url_title' => Yii::t('YcmModule.places', 'url_title'),
			'status' => Yii::t('YcmModule.places', 'status'),
			'name' => Yii::t('YcmModule.places', 'name'),
			'schedule' => Yii::t('YcmModule.places', 'schedule'),
			'place_desc' => Yii::t('YcmModule.places', 'place_desc'),
			'street' => Yii::t('YcmModule.places', 'street'),
			'street_number' => Yii::t('YcmModule.places', 'street_number'),
			'phone' => Yii::t('YcmModule.places', 'phone'),
			'phone2' => Yii::t('YcmModule.places', 'phone2'),
			'admin_phone' => Yii::t('YcmModule.places', 'admin_phone'),
			'website' => Yii::t('YcmModule.places', 'website'),
			'email' => Yii::t('YcmModule.places', 'email'),
			'cost' => Yii::t('YcmModule.places', 'cost'),
			'lat' => Yii::t('YcmModule.places', 'lat'),
			'lng' => Yii::t('YcmModule.places', 'lng'),
			'order_discount' => Yii::t('YcmModule.places', 'order_discount'),
			'order_discount_banket' => Yii::t('YcmModule.places', 'order_discount_banket'),
			'search_mistakes' => Yii::t('YcmModule.places', 'search_mistakes'),
			'closed' => Yii::t('YcmModule.places', 'closed'),
		);
	}
	
	public function rules() {
		return array(
			array('title, url_title, status, schedule, street, street_number, phone, lat, lng', 'required'),
			array('name, place_desc, phone2, email, admin_phone, website, cost, order_discount, order_discount_banket, search_mistakes, closed', 'safe'),
		);
	}
	
	public function attributeWidgets() {
		return array(
			array('title', 'textField'),
			array('url_title', 'textField'),
			array('status', 'dropDown'),
			array('name', 'textField'),
			array('schedule', 'textField'),
			array('place_desc', 'wysiwyg'),
			array('street', 'textField'),
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
			array('search_mistakes', 'textField'),
			array('closed', 'textField'),
		);
	}
	
	public function statusChoices() {
		return array(
			'open' => 'open',
			'closed' => 'closed'
		);
	}
	
	public function relations() {
		return array(
			'places_photo' => array(self::HAS_MANY, 'PlacesPhotoModel', array('place_id' => 'place_id'))
		);
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
}