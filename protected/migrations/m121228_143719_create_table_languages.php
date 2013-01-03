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
			'code' => 'ru',
			'name' => 'Русский',
			'default' => 1,
			'enabled' => 1
		));
		
		$this->insert('languages', array(
			'code' => 'ua',
			'name' => 'Укр. мова.',
			'default' => 0,
			'enabled' => 1
		));
		
		$this->insert('languages', array(
			'code' => 'en',
			'name' => 'English',
			'default' => 0,
			'enabled' => 1
		));
		
		$this->insert('languages', array(
			'code' => 'ch',
			'name' => 'China',
			'default' => 0,
			'enabled' => 0
		));
	}

	public function down() {
		$this->dropTable('languages');
		return true;
	}
}