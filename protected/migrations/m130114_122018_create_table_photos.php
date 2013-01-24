<?php

class m130114_122018_create_table_photos extends CDbMigration
{
	public function up()
	{
		$this->createTable('photos', array(
			'photo_id' => 'INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'album_id' => 'INT UNSIGNED',
			'user_id' => 'INT UNSIGNED NOT NULL',
			'title' => 'VARCHAR(100)',
			'url' => 'VARCHAR(150)',
			'photoPath' => 'VARCHAR(150)',
			'ip_address' => 'VARCHAR(15)',
			'status' => 'BOOLEAN NOT NULL DEFAULT 1',
				), 'ENGINE=InnoDB COLLATE=utf8_general_ci');
		
		$this->createIndex('album_id', 'photos', 'album_id');
		
		$this->addForeignKey('album_id_fk', 'photos', 'album_id', 'albums', 'album_id', 'CASCADE', 'CASCADE');
	}

	public function down()
	{
		$this->dropTable("photos");
		return true;
	}
}