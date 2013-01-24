<?php

class m130114_121935_create_table_albums extends CDbMigration
{
	public function up()
	{
		$this->createTable('albums', array(
			'album_id' => 'INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'place_id' =>  'INT',
			'user_id' => 'INT UNSIGNED NOT NULL',
			'title' => 'VARCHAR(100)',
			'url' => 'VARCHAR(150)',
			'album_cover' => 'VARCHAR(150)',
			'albumEvent' => 'INT',
			'ip_address' => 'VARCHAR(15)',
			'album_date' => 'DATE',
			'status' => 'BOOLEAN NOT NULL DEFAULT 1',
				), 'ENGINE=InnoDB COLLATE=utf8_general_ci');
	}

	public function down()
	{
		$this->dropTable("albums");
		return true;
	}
}