<?php

class m130125_135019_create_table_places_categories_to_filters extends CDbMigration
{
	public function up() {
		$this->createTable("places_categories_to_filters", array(
			'category_id' => 'INT UNSIGNED NOT NULL',
			'filter_id' => 'INT UNSIGNED NOT NULL',
		), 'ENGINE=InnoDB COLLATE=utf8_general_ci');
		
		$this->createIndex('category_id_filter_id', 'places_categories_to_filters', 'category_id,filter_id', true);
		
		$this->createIndex('category_id', 'places_categories_to_filters', 'category_id');
		$this->createIndex('filter_id', 'places_categories_to_filters', 'filter_id');

		$this->addForeignKey('category_id_ctf_fk', 'places_categories_to_filters', 'category_id', 'places_categories', 'category_id', 'CASCADE', 'CASCADE');

		$this->addForeignKey('filter_id_ctf_fk', 'places_categories_to_filters', 'filter_id', 'filters', 'filter_id', 'CASCADE', 'CASCADE');
	}

	public function down() {
		$this->dropTable("places_categories_to_filters");
		return true;
	}
}