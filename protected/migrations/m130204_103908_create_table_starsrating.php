<?php

class m130204_103908_create_table_starsrating extends CDbMigration
{
	public function up() {
		$this->createTable("starsrating", array(
			'rating_id' => 'INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'entry_id' => 'INT UNSIGNED NOT NULL',
			'rating' => 'ENUM("1", "2", "3", "4", "5") NOT NULL',
			'user_id' => 'INT UNSIGNED NOT NULL',
			'date' => 'DATETIME',
			'ip_address' => 'VARCHAR(15)',
		), 'ENGINE=InnoDB COLLATE=utf8_general_ci');
		
		$this->createIndex('entry_id', 'starsrating', 'entry_id');
	}

	public function down() {
		$this->dropTable("starsrating");
		return true;
	}
}