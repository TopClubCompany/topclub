<?php

class FiltersValuesModel extends CActiveRecord {

	/**
	 * 
	 * @param type $className
	 * @return FiltersValuesModel
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'filters_values';
	}

	public function primaryKey() {
		return 'value_id';
	}

	public function attributeLabels() {
		return array(
			'value_id' => 'ID',
			'url' => 'URL',
			'filter_id' => Yii::t('YcmModule.filters', 'Filter'),
		);
	}
	
	public function attributeWidgets() {
		return array(
			array('url', 'textField'),
			array('filter_id', 'dropDown'),
		);
	}
	
	public function filter_idChoices() {
		return CHtml::listData(FiltersModel::model()->findAll(), 'filter_id', 'url');
	}
	
	public function rules() {
		return array(
			array('filter_id', 'safe'),
			array('url', 'required')
		);
	}

	public function search() {
		$criteria = new CDbCriteria();
		if ($_GET['FiltersValuesModel']) {
			if ($filter_id = (int) $_GET['FiltersValuesModel']['filter_id'] ? : null) {
				$this->filter_id = $filter_id;
				$criteria->addCondition('filter_id=:filter_id');
				$criteria->params = array_merge($criteria->params, array(
					':filter_id' => $filter_id
				));
			}
		}
		return new CActiveDataProvider($this, array(
					'criteria' => $criteria
				));
	}

}
