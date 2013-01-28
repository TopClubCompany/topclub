<?php

class UsersModel extends CActiveRecord {

	public $password_repeat;
	//public $roleArr = array('guest', 'user', 'moderator', 'editor', 'maineditor', 'administrator');

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
			'user_id' => Yii::t('YcmModule.users', 'User id'),
			'role' => Yii::t('YcmModule.users', 'Role'),
			'username' => Yii::t('YcmModule.users', 'Username'),
			'first_name' => Yii::t('YcmModule.users', 'First name'),
			'last_name' => Yii::t('YcmModule.users', 'Last name'),
			'password' => Yii::t('YcmModule.users', 'Password'),
			'password_repeat' => Yii::t('YcmModule.users', 'Password repeat'),
			'location' => Yii::t('YcmModule.users', 'Location'),
			'phone' => Yii::t('YcmModule.users', 'Phone'),
			'vk_id' => Yii::t('YcmModule.users', 'Vk id'),
			'fb_id' => Yii::t('YcmModule.users', 'Fb id'),
			'tw_id' => Yii::t('YcmModule.users', 'Tw id')
		);
	}

	public function beforeSave() {
		if(!$this->vk_id)
			unset ($this->vk_id);
		if(!$this->fb_id)
			unset ($this->fb_id);
		if(!$this->tw_id)
			unset ($this->tw_id);
		if ($this->getIsNewRecord()){
			/* DOCS
			 * http://www.yiiframework.com/extension/mail
			 * http://phpmailer.worxware.com/index.php?pg=methods
			 */
			$message = "Регистрация!\r\n";
			$message .= $this->first_name . " " .$this->last_name;
			$message .= "\r\nтвоя регистрация прошла успешно!\r\nТвой пароль: ".$this->password;
			//Yii::app()->mailer->Host = 'smtp.yiiframework.com';
			Yii::app()->mailer->IsSMTP();
			Yii::app()->mailer->From = 'info@topclub.com';
			Yii::app()->mailer->FromName = 'TopCLub';
			Yii::app()->mailer->AddReplyTo('info@topclub.com');
			Yii::app()->mailer->AddAddress($this->username);
			Yii::app()->mailer->Subject = Yii::t('YcmModule.users', 'Mail subject');
			Yii::app()->mailer->Body = $message;
			//Yii::app()->mailer->MsgHTML($message);
			Yii::app()->mailer->Send();
			
			if($this->password !== $this->password_repeat)
				throw new CHttpException(404, Yii::t('YcmModule.users', 'Error password'));	
			else
				$this->password = sha1(trim($this->password));
		}
		if (isset($this->password) && $this->password != '') {
			$this->password = sha1(trim($this->password));
		}
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
			array('password', 'password'),
			array('password_repeat', 'password'),
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
			array('first_name, last_name, username', 'required'),
			array('password, password_repeat, role', 'required', 'on' => array('users_update')),
			array('username', 'unique', 'attributeName' => 'username'),
			array('phone', 'match', 'pattern' => '/\d{12}/'),
			array('last_name, location', 'match', 'pattern' => '/[a-zа-я_-]/i'),
			array('username', 'email'),
			array('vk_id, fb_id, tw_id', 'match', 'pattern' => '/\d+/'),
			array('password_repeat', 'compare', 'compareAttribute'=>'password', 'on'=> 'users_update', 'message' => Yii::t('YcmModule.profile', 'Password must be repeated exactly.')),
			array('password_repeat', 'compare', 'compareAttribute'=>'password', 'on'=> 'profile_update', 'message' => Yii::t('YcmModule.profile', 'Password must be repeated exactly.')),
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
}