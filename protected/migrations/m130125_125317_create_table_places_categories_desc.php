<?php

class m130125_125317_create_table_places_categories_desc extends CDbMigration
{
	public function up() {
		$this->createTable("places_categories_desc", array(
			'category_id' => 'INT UNSIGNED NOT NULL',
			'language_id' => 'SMALLINT UNSIGNED NOT NULL',
			'name' => 'VARCHAR(50) NOT NULL',
			'description' => 'TEXT'
		), 'ENGINE=InnoDB COLLATE=utf8_general_ci');
		
		$this->createIndex('category_id_language_id', 'places_categories_desc', 'category_id,language_id', true);
		
		$this->createIndex('category_id', 'places_categories_desc', 'category_id');
		$this->createIndex('language_id', 'places_categories_desc', 'language_id');

		$this->addForeignKey('category_id_fk', 'places_categories_desc', 'category_id', 'places_categories', 'category_id', 'CASCADE', 'CASCADE');

		$this->addForeignKey('language_id_place_cat_desc_fk', 'places_categories_desc', 'language_id', 'languages', 'language_id', 'CASCADE', 'CASCADE');
	}

	public function down() {
		$this->dropTable("places_categories_desc");
		return true;
	}
}