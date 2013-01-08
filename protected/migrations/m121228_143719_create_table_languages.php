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
		
		$this->insert('languages', array(
			'language_id' => 1,
			'code' => 'ru',
			'name' => 'Русский',
			'default' => 1,
			'enabled' => 1
		));
		
		$this->insert('languages', array(
			'language_id' => 2,
			'code' => 'ua',
			'name' => 'Українська',
			'default' => 0,
			'enabled' => 1
		));
		
		$this->insert('languages', array(
			'language_id' => 3,
			'code' => 'en',
			'name' => 'English',
			'default' => 0,
			'enabled' => 1
		));
		
		$this->insert('languages', array(
			'language_id' => 4,
			'code' => 'ch',
			'name' => 'Китайский',
			'default' => 0,
			'enabled' => 0
		));
	}

	public function down() {
		$this->dropTable('languages');
		return true;
	}
}