<?php

class m130118_094044_create_table_places_desc extends CDbMigration {

	public function up() {
		$this->createTable("places_desc", array(
			'place_id' => 'INT UNSIGNED NOT NULL',
			'language_id' => 'SMALLINT UNSIGNED NOT NULL',
			'title' => 'VARCHAR(100)',
			//'name' => 'VARCHAR(50)',
			'place_desc' => 'TEXT',
			'street' => 'VARCHAR(50)',
			'place_orientir' => 'VARCHAR(255)',
			'search_mistakes' => 'TEXT',
		), 'ENGINE=InnoDB COLLATE=utf8_general_ci');
		
		$this->createIndex('place_language', 'places_desc', 'place_id,language_id', true);
		
		$this->createIndex('place_id', 'places_desc', 'place_id');
		
		$this->createIndex('language_id', 'places_desc', 'language_id');
		
		$this->addForeignKey('place_id_fk', 'places_desc', 'place_id', 'places', 'place_id', 'CASCADE', 'CASCADE');
	}

	public function down() {
		$this->dropTable("places_desc");
		return true;
	}
}