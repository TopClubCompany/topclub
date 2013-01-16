<?php

class m130104_150041_create_table_filters_values extends CDbMigration {

	public function up() {
		$this->createTable('filters_values', array(
			'value_id' => 'INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'filter_id' => 'INT UNSIGNED NOT NULL',
			'url' => 'VARCHAR(50) NOT NULL'
				), 'ENGINE=InnoDB COLLATE=utf8_general_ci');

		$this->createIndex('filter_id', 'filters_values', 'filter_id');
		$this->createIndex('filter_id_url', 'filters_values', 'filter_id,url', true);

		//error find wtf?
		//$this->addForeignKey('filter_id_fk', 'filters_values', 'filter_id', 'filters', 'filter_id', 'CASCADE', 'CASCADE');
	}

	public function down() {
		$this->dropTable('filters_values');
		return true;
	}

}
