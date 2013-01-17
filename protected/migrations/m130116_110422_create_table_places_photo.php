<?php

class m130116_110422_create_table_places_photo extends CDbMigration {

	public function up() {
		$this->createTable('places_photo', array(
			'photo_id' => 'INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'place_id' => 'INT UNSIGNED NOT NULL',
			'filename' => 'VARCHAR(50)', // in future 'CHAR(37)' md5 + . + расширение картинки
			), 'ENGINE=InnoDB COLLATE=utf8_general_ci');

		$this->createIndex('place_id', 'places_photo', 'place_id');
	}

	public function down() {
		$this->dropTable('places_photo');
		return true;
	}
}