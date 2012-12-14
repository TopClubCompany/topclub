<?php

class m121214_120843_create_table_places_desc extends CDbMigration {

	public function up() {
		$this->createTable('places_desc', array(
			'place_id' => 'INT UNSIGNED NOT NULL',
			'lang_id' => 'TINYINT UNSIGNED NOT NULL',
			'name' => 'VARCHAR(255) NOT NULL',
			'description' => 'TEXT',
		), null);
	}

	public function down() {
		$this->dropTable('places_desc');
		echo "Таблица places_desc удалена\n";
		return true;
	}
}