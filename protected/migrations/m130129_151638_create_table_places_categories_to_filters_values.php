<?php

class m130129_151638_create_table_places_categories_to_filters_values extends CDbMigration
{
	public function up() {
		$this->createTable("places_categories_to_filters_values", array(
			'place_id' => 'INT UNSIGNED NOT NULL',
			'filter_id' => 'INT UNSIGNED NOT NULL',
			'value_id' => 'INT UNSIGNED NOT NULL',
		), 'ENGINE=InnoDB COLLATE=utf8_general_ci');
		
		$this->createIndex('place_id_filter_id', 'places_categories_to_filters_values', 'place_id,filter_id');
		$this->createIndex('place_id', 'places_categories_to_filters_values', 'place_id');
		$this->createIndex('filter_id', 'places_categories_to_filters_values', 'filter_id');
		$this->createIndex('place_filter_value', 'places_categories_to_filters_values', 'place_id,filter_id,value_id', true);
		$this->addForeignKey('place_id_ctfv_fk', 'places_categories_to_filters_values', 'place_id', 'places', 'place_id', 'CASCADE', 'CASCADE');
		$this->addForeignKey('filter_id_ctfv_fk', 'places_categories_to_filters_values', 'filter_id', 'filters', 'filter_id', 'CASCADE', 'CASCADE');
		$this->addForeignKey('value_id_ctfv_fk', 'places_categories_to_filters_values', 'value_id', 'filters_values', 'value_id', 'CASCADE', 'CASCADE');
	}

	public function down() {
		$this->dropTable("places_categories_to_filters_values");
		return true;
	}

}