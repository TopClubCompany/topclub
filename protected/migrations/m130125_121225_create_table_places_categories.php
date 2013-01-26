<?php

class m130125_121225_create_table_places_categories extends CDbMigration
{
	public function up() {
		$this->createTable("places_categories", array(
			'category_id' => 'INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'url' => 'VARCHAR(50) NOT NULL UNIQUE'
		), 'ENGINE=InnoDB COLLATE=utf8_general_ci');
		$this->createIndex('category_id', 'places_categories', 'category_id');
	}

	public function down() {
		$this->dropTable("places_categories");
		return true;
	}
}