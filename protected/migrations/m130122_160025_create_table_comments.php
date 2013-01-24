<?php

class m130122_160025_create_table_comments extends CDbMigration {

	public function up() {
		$this->createTable("comments", array(
			'comment_id' => 'INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'entry_id' => 'INT UNSIGNED NOT NULL',
			'language_id' => 'TINYINT UNSIGNED NOT NULL',
			'type' => 'ENUM("places", "articles", "events", "photos", "albums") NOT NULL',
			'user_id' => 'INT UNSIGNED NOT NULL',
			'comment' => 'TEXT',
			'ip_address' => 'VARCHAR(15)',
			'comment_date' => 'INT(10)',
			'status' => 'BOOLEAN NOT NULL DEFAULT 1',
		), 'ENGINE=InnoDB COLLATE=utf8_general_ci');
	}

	public function down() {
		$this->dropTable("comments");
		return true;
	}
}