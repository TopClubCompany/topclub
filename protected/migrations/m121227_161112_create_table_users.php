<?php

class m121227_161112_create_table_users extends CDbMigration {

	public function up() {
		$this->createTable('users', array(
			'user_id' => 'INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'role' => "ENUM('guest', 'user', 'moderator', 'editor', 'maineditor', 'administrator') NOT NULL DEFAULT 'guest'",
			'username' => 'VARCHAR(50) NOT NULL UNIQUE', // username == email
			'password' => 'CHAR(32) NOT NULL',
			'first_name' => 'VARCHAR(50) NOT NULL',
			'last_name' => 'VARCHAR(50) NOT NULL',
			'location' => 'VARCHAR(50)',
			'photo_file_name' => 'CHAR(100)', // md5(microtime()) . '.' . $extension
			'phone' => 'VARCHAR(15)',
			'vk_id' => 'BIGINT UNSIGNED UNIQUE',
			'fb_id' => 'BIGINT UNSIGNED UNIQUE',
			'tw_id' => 'BIGINT UNSIGNED UNIQUE',
		), ' ENGINE=InnoDB COLLATE=utf8_general_ci');
		
		$this->insert('users', array(
			'role' => 'administrator',
			'username' => 'root@root.ua',
			'password' => md5('root'),
			'first_name' => 'root',
			'last_name' => 'root',
		));
		
		$this->insert('users', array(
			'role' => 'moderator',
			'username' => 'moderator@root.ua',
			'password' => md5('moderator'),
			'first_name' => 'moderator',
			'last_name' => 'moderator',
		));
		
		$this->insert('users', array(
			'role' => 'editor',
			'username' => 'editor@root.ua',
			'password' => md5('editor'),
			'first_name' => 'editor',
			'last_name' => 'editor',
		));
	}

	public function down() {
		$this->dropTable('users');
		return true;
	}

}