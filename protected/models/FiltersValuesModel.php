<?php
class FiltersValuesModel extends CActiveRecord {
	public function tableName() {
		return 'filters_values';
	}

	public function primaryKey() {
		return 'value_id';
	}
}
