<?php

class m130110_102238_create_table_filters_values_desc extends CDbMigration {

	public function up() {
		$this->createTable('filters_values_desc', array(
			'value_id' => 'INT UNSIGNED NOT NULL',
			'language_id' => 'SMALLINT UNSIGNED NOT NULL',
			'name' => 'VARCHAR(50) NOT NULL',
			'description' => 'TEXT'
		), 'ENGINE=InnoDB COLLATE=utf8_general_ci');
		
		$this->createIndex('value_id', 'filters_values_desc', 'value_id');
		$this->createIndex('language_id', 'filters_values_desc', 'language_id');
		$this->addForeignKey('filter_values_id_fk', 'filters_values_desc', 'value_id', 'filters_values', 'value_id', 'CASCADE', 'CASCADE');
	}

	public function down() {
		$this->dropTable('filters_values_desc');
		return true;
	}

}