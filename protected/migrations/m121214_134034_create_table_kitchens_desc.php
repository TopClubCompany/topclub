<?php

class m121214_134034_create_table_kitchens_desc extends CDbMigration {

	public function up() {
		$this->createTable('kitchens_desc', array(
			'kitchen_id' => 'SMALLINT UNSIGNED NOT NULL',
			'language_id' => 'TINYINT UNSIGNED NOT NULL',
			'name' => 'VARCHAR(255) NOT NULL',
			'description' => 'TEXT',
		), 'ENGINE=INNODB COLLATE=utf8_general_ci');
	}

	public function down() {
		$this->dropTable('kitchens');
		echo "Таблица kitchens удалена\n";
		return true;
	}
}