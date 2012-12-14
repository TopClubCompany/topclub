<?php

class m121214_132627_create_table_languages extends CDbMigration {

	public function up() {
		$this->createTable('languages', array(
			'language_id' => 'TINYINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
			'slug' => 'CHAR(2) NOT NULL UNIQUE',
			'name' => 'VARCHAR(100)'
		), 'ENGINE=INNODB COLLATE=utf8_general_ci');
	}

	public function down() {
		$this->dropTable('languages');
		echo "Таблица languages удалена\n";
		return true;
	}
}