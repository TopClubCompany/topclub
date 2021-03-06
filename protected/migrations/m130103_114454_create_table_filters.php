<?php

class m130103_114454_create_table_filters extends CDbMigration {

	public function up() {
		$this->createTable('filters', array(
			'filter_id' => 'INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'url' => 'VARCHAR(50) NOT NULL UNIQUE'
				), 'ENGINE=InnoDB COLLATE=utf8_general_ci');
	}

	public function down() {
		$this->dropTable('filters');
		return true;
	}

}