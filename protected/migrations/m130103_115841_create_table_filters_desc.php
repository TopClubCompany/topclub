<?php

class m130103_115841_create_table_filters_desc extends CDbMigration {

	public function up() {
		$this->createTable('filters_desc', array(
			'filter_id' => 'INT UNSIGNED NOT NULL',
			'language_id' => 'SMALLINT UNSIGNED NOT NULL',
			'name' => 'VARCHAR(50) NOT NULL',
			'description' => 'TEXT'
		));
		$this->createIndex('filter_id_language_id', 'filters_desc', 'filter_id,language_id', true);

		$this->createIndex('filter_id', 'filters_desc', 'filter_id');
		$this->createIndex('language_id', 'filters_desc', 'language_id');

		$this->addForeignKey('filter_id_fk', 'filters_desc', 'filter_id', 'filters', 'filter_id', 'CASCADE', 'CASCADE');

		$this->addForeignKey('language_id_fk', 'filters_desc', 'language_id', 'languages', 'language_id', 'CASCADE', 'CASCADE');
	}

	public function down() {
		$this->dropTable('filters_desc');
		return true;
	}
}