<?php

class m121214_133823_create_table_places_to_kitchens extends CDbMigration {

	public function up() {
		$this->createTable('places_to_kitchens', array(
			'place_id' => 'INT UNSIGNED NOT NULL',
			'kitchen_id' => 'SMALLINT UNSIGNED NOT NULL',
			'created_by' => 'SMALLINT UNSIGNED NOT NULL',
			'edited_by' => 'SMALLINT UNSIGNED NOT NULL',
			'created_at' => 'DATETIME',
			'updated_at' => 'DATETIME',
		), null);
		$this->createIndex('place_id', 'places_to_kitchens', 'place_id');
		$this->createIndex('kitchen_id', 'places_to_kitchens', 'kitchen_id');
	}

	public function down() {
		$this->dropTable('places_to_kitchens');
		echo "Таблица places_to_kitchens удалена\n";
		return true;
	}
}