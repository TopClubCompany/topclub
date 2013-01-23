<?php

class m130122_152850_create_table_channels extends CDbMigration {

	public function up() {
		$this->createTable("channels", array(
			'channel_id' => 'INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'channel_name' => 'CHAR(30)',
			'channel_title' => 'CHAR(50)',
			'channel_url' => 'CHAR(50)',
		), 'ENGINE=InnoDB COLLATE=utf8_general_ci');
	}

	public function down() {
		$this->dropTable("channels");
		return true;
	}

	/*
	  // Use safeUp/safeDown to do migration with transaction
	  public function safeUp()
	  {
	  }

	  public function safeDown()
	  {
	  }
	 */
}