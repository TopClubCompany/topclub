<?php

class m130114_093642_create_table_events extends CDbMigration
{
	public function up()
	{
		$this->createTable('events', array(
			'event_id' => 'INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'author_id' => 'INT UNSIGNED NOT NULL',
			'title' => 'VARCHAR(100)',
			'url' => 'VARCHAR(150)',
			'event_desc' =>  'TEXT',
			'event_place' => 'INT',
			'event_alternative_place' => 'VARCHAR(150)',
			'event_alternative_place_details' => 'VARCHAR(150)',
			'event_entrance_male' => 'INT',
			'event_entrance_female' => 'INT',
			'event_img' => 'VARCHAR(150)',
			'ip_address' => 'VARCHAR(15)',
			'event_date' => 'DATE',
			'status' => 'BOOLEAN NOT NULL DEFAULT 1',
				), 'ENGINE=InnoDB COLLATE=utf8_general_ci');
	}

	public function down()
	{
		$this->dropTable('events');
		return true;
	}
}