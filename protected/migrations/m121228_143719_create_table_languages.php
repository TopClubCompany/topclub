<?php

class m121228_143719_create_table_languages extends CDbMigration {

	public function up() {
		$this->createTable('languages', array(
			'language_id' => 'SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'order' => 'SMALLINT UNSIGNED NOT NULL DEFAULT 1',
			'code' => 'CHAR(2) NOT NULL UNIQUE',
			'name' => 'VARCHAR(50) NOT NULL',
			'default' => 'BOOLEAN NOT NULL DEFAULT FALSE',
			'enabled' => 'BOOLEAN NOT NULL DEFAULT TRUE'
		), ' ENGINE=InnoDB COLLATE=utf8_general_ci');
	}

	public function down() {
		return true;
	}
}