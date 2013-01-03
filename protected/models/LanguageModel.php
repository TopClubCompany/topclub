<?php

class LanguageModel extends CActiveRecord {

	/**
	 * 
	 * @param String $className
	 * @return Languages
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function attributeLabels() {
		return array(
			'language_id' => 'ID',
			'code' => 'URL',
			'name' => 'Название',
			'enabled' => 'Включен',
			'default' => 'Язык по-умолчанию',
			'order' => 'Порядок отображения'
		);
	}
	
	public function beforeSave() {
		if ($this->default == 1)
			$this->updateAll(array('default' => 0));
		return parent::beforeSave();
	}

	public function attributeWidgets() {
		return array(
			array('code', 'textField'),
			array('name', 'textField'),
			array('enabled', 'boolean'),
			array('default', 'boolean'),
		);
	}

	public function rules() {
		return array(
			array('code,name', 'required'),
			array('code', 'unique', 'attributeName' => 'code'),
			array('code', 'match', 'pattern' => '/[a-z]{2}/i'),
			array('default,enabled', 'safe'),
		);
	}

	public function tableName() {
		return 'languages';
	}

	public function primaryKey() {
		return 'language_id';
	}

	public function search() {
		return new CActiveDataProvider($this);
	}

	public function scopes() {
		return array(
			'enabled' => array(
				'condition' => 'enabled=1'
			)
		);
	}

}