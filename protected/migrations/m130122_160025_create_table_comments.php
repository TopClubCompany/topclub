<?php

class m130122_160025_create_table_comments extends CDbMigration {

	public function up() {
		$this->createTable("comments", array(
			'comment_id' => 'INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'place_id' => 'INT UNSIGNED',
			'language_id' => 'TINYINT UNSIGNED NOT NULL',
			'channel_id' => 'TINYINT UNSIGNED NOT NULL',
			'user_id' => 'INT UNSIGNED NOT NULL',
			'name' => 'VARCHAR(50)',
			'email' => 'VARCHAR(50)',
			'location' => 'VARCHAR(50)',
			'comment' => 'TEXT',
			'ip_address' => 'VARCHAR(15)',
			'comment_date' => 'DATE',
			'status' => 'ENUM ("o", "c") NOT NULL DEFAULT "o"',
				), 'ENGINE=InnoDB COLLATE=utf8_general_ci');
	}

	public function down() {
		$this->dropTable("comments");
		return true;
	}
}