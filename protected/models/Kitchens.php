<?php

class Kitchens extends CActiveRecord {

	public $kitchen_id,
			$slug;
	public $adminNames = array('Кухни', 'кухню', 'Кухни'); // admin interface, singular, plural
	public $downloadExcel = false; // Download Excel
	public $downloadMsCsv = false; // Download MS CSV
	public $downloadCsv = false; // Download CSV

	/**
	 * Behaviors.
	 * @return array
	 */

	function behaviors() {
		return array(
			'file' => array(
				'class' => 'application.modules.ycm.behaviors.FileBehavior',
			),
		);
	}
	
	public function beforeSave() {
		print_r($_POST);
		die;
		return false;
	}

	public function attributeLabels() {
		return array(
			'kitchen_id' => Yii::t('ycmfields', 'id'),
			'slug' => Yii::t('ycmfields', 'slug')
		);
	}

	public function rules() {
		return array(
			array('slug', 'unique', 'attributeName' => 'slug'),
			array('slug', 'match', 'pattern' => '/[a-z09\-\_]/i')
		);
	}

	/**
	 * 
	 * @param String $className
	 * @return Kitchens
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'kitchens';
	}

	public function primaryKey() {
		return 'kitchen_id';
	}

	public function search() {
		return new CActiveDataProvider($this, array(
				));
	}

	public function attributeWidgets() {
		return array(
			array('slug', 'textField'),
			array('desc.name', 'textField'),
			array('desc.description', 'wysiwyg'),
		);
	}

	public function adminSearch() {
		return array(
			'columns' => array(
				array(
					'name' => 'kitchen_id',
					'filter' => false
				), array(
					'name' => 'name',
					'value' => '$data->desc_ru->name',
					'filter' => false
				),
				array(
					'name' => 'slug',
					'filter' => false
				),
			),
		);
	}

	public function defaultScope() {
		return array(
		);
	}

	public function relations() {
		return array(
			'desc' => array(self::HAS_MANY, 'KitchensDesc', array('kitchen_id' => 'kitchen_id'), 'order' => 'lang ASC'),
			'desc_ru' => array(self::HAS_ONE, 'KitchensDesc', array('kitchen_id' => 'kitchen_id'), 'condition' => 'language_id=1')
		);
	}

	public function tabForm() {
		$languages = Languages::model()->enabled()->findAll();
		$tabForm = array();
		foreach ($languages as $language) {
			if (!$model = KitchensDesc::model()->find('kitchen_id=:kitchen_id AND language_id=:language_id', array(':language_id' => $language->language_id, ':kitchen_id' => $this->kitchen_id)))
				$model = KitchensDesc::model();
			$tabForm[$language->name] = array(
				'model' => $model,
				'attributes' => array(
					'language_id',
					'name',
					'description',
				),
			);
		}
		return $tabForm;
	}

}