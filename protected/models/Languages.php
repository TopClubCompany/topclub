<?php

class Languages extends CActiveRecord {

	public $language_id,
			$slug,
			$name,
			$enabled,
			$default;
	public $adminNames = array('Языки', 'язык', 'Языки'); // admin interface, singular, plural
	public $downloadExcel = false; // Download Excel
	public $downloadMsCsv = false; // Download MS CSV
	public $downloadCsv = false;
	
	/**
	 * 
	 * @param String $className
	 * @return Languages
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
	
	function behaviors() {
		return array(
			'file' => array(
				'class' => 'application.modules.ycm.behaviors.FileBehavior',
			),
		);
	}

	public function attributeLabels() {
		return array(
			'language_id' => 'ID',
			'slug' => 'URL',
			'name' => 'Название',
			'enabled' => 'Включен',
			'default' => 'Язык по-умолчанию'
		);
	}
	
	public function attributeWidgets() {
		return array(
			array('slug', 'textField'),
			array('name', 'textField'),
			array('enabled', 'boolean'),
			array('default', 'wysiwyg')
		);
	}

	public function rules() {
		return array(
			array('slug,name', 'required'),
			array('slug', 'unique', 'attributeName' => 'slug'),
			array('slug', 'match', 'pattern' => '/[a-z]{2,3}/i'),
			array('enabled, default', 'safe')
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

	public function adminSearch() {
		return array(
			'filter' => false,
			'columns' => array(
				array(
					'name' => 'language_id',
					'filter' => false
				), array(
					'name' => 'name',
					'filter' => false
				),
				array(
					'name' => 'slug',
					'filter' => false
				),
				array(
					'name' => 'enabled',
					'value' => '($data->enabled == 1) ? Yii::t("common", "yes") : Yii::t("common", "no");',
					'filter' => false
				),
				array(
					'name' => 'default',
					'value' => '($data->default == 1) ? Yii::t("common", "yes") : Yii::t("common", "no");',
					'filter' => false
				)
			),
		);
	}

}