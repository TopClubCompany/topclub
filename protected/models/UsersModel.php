<?php

class UsersModel extends CActiveRecord {

	public $password_repeat;
	public $roleArr = array('guest', 'user', 'moderator', 'editor', 'maineditor', 'administrator');

	/**
	 * 
	 * @param String $className
	 * @return Users
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function attributeLabels() {
		return array(
			'user_id' => Yii::t('YcmModule.users', 'user_id'),
			'role' => Yii::t('YcmModule.users', 'role'),
			'username' => Yii::t('YcmModule.users', 'username'),
			'first_name' => Yii::t('YcmModule.users', 'first_name'),
			'last_name' => Yii::t('YcmModule.users', 'last_name'),
			'password' => Yii::t('YcmModule.users', 'password'),
			'password_repeat' => Yii::t('YcmModule.users', 'password_repeat'),
			'location' => Yii::t('YcmModule.users', 'email'),
			'email' => Yii::t('YcmModule.users', 'user_id'),
			'phone' => Yii::t('YcmModule.users', 'phone'),
			'vk_id' => Yii::t('YcmModule.users', 'vk_id'),
			'fb_id' => Yii::t('YcmModule.users', 'fb_id'),
			'tw_id' => Yii::t('YcmModule.users', 'tw_id')
		);
	}

	public function beforeSave() {
		if ($this->getIsNewRecord())
			$this->password = md5($this->password);
		return parent::beforeSave();
	}

	public function attributeWidgets() {
		return array(
			array('user_id', 'textField'),
			array('role', 'dropDown'),
			array('username', 'textField'),
			array('first_name', 'textField'),
			array('last_name', 'textField'),
			array('location', 'textField'),
			array('email', 'textField'),
			array('password', 'textField'),
			array('password_repeat', 'textField'),
			array('phone', 'textField'),
			array('vk_id', 'textField'),
			array('fb_id', 'textField'),
			array('tw_id', 'textField')
		);
	}

	public function roleChoices() {
		return array(
			'guest' => 'guest',
			'user' => 'user',
			'moderator' => 'moderator',
			'editor' => 'editor',
			'maineditor' => 'maineditor',
			'administrator' => 'administrator',
		);
	}

	public function rules() {
		return array(
			array('role, first_name, last_name, password, password_repeat, username, email', 'required'),
			array('username', 'unique', 'attributeName' => 'username'),
			array('phone', 'match', 'pattern' => '/\d{12}/'),
			array('username, last_name, location', 'match', 'pattern' => '/[a-zа-я_-]/i'),
			array('email', 'email'),
			array('vk_id, fb_id, tw_id', 'match', 'pattern' => '/\d+/'),
			array('password', 'compare', 'compareAttribute' => 'password_repeat', 'on' => array('add','edit')),
		);
	}

	public function tableName() {
		return 'users';
	}

	public function primaryKey() {
		return 'user_id';
	}

	public function search() {
		return new CActiveDataProvider($this);
	}

	/* public function scopes() {
	  return array(
	  'enabled' => array(
	  'condition' => 'enabled=1'
	  )
	  );
	  } */
}