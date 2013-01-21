<?php

class m130114_122018_create_table_photos extends CDbMigration
{
	public function up()
	{
		$this->createTable('photos', array(
			'photo_id' => 'INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'album_id' => 'INT UNSIGNED',
			'author_id' => 'INT UNSIGNED NOT NULL',
			'title' => 'VARCHAR(100)',
			'url_title' => 'VARCHAR(150)',
			'photoPath' => 'VARCHAR(150)',
			'ip_address' => 'VARCHAR(15)',
			//'album_date' => 'DATE',
			'status' => 'ENUM ("open", "closed") NOT NULL DEFAULT "open"',
				), 'ENGINE=InnoDB COLLATE=utf8_general_ci');
	}

	public function down()
	{
		$this->dropTable("photos");
		return true;
	}
}