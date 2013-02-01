<?php

class m130131_151714_create_table_places_timetable extends CDbMigration
{
	public function up() {
		$this->createTable("places_timetable", array(
			'place_id' => 'INT UNSIGNED NOT NULL',
			'day' => 'ENUM("monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday") NOT NULL',
			'from' => 'TIME DEFAULT "00:00:00"',
			'to' => 'TIME DEFAULT NULL',
			'day_and_night' => 'BOOLEAN NOT NULL DEFAULT 1',
		), 'ENGINE=InnoDB COLLATE=utf8_general_ci');
		
		$this->createIndex('place_id', 'places_timetable', 'place_id');
		$this->createIndex('day', 'places_timetable', 'day');
		$this->createIndex('from', 'places_timetable', 'from');
		$this->createIndex('to', 'places_timetable', 'to');
		$this->createIndex('day_and_night', 'places_timetable', 'day_and_night');
		$this->addForeignKey('place_id_timetable_fk', 'places_timetable', 'place_id', 'places', 'place_id', 'CASCADE', 'CASCADE');
	}

	public function down() {
		$this->dropTable("places_timetable");
		return true;
	}
}