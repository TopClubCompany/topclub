<?php

class m121227_161112_create_table_users extends CDbMigration {

	public function up() {
		$this->createTable('users', array(
			'user_id' => 'INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'old_user_id' => 'INT UNSIGNED',
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
			'sex' => 'CHAR(1) NOT NULL',
			'ip_address' => 'VARCHAR(15)',
			'join_date' => 'INT(10) UNSIGNED',
			'status' => 'VARCHAR(255)',
			'birth' => 'DATE',
		), ' ENGINE=InnoDB COLLATE=utf8_general_ci');
		
		$this->insert('users', array(
			'role' => 'administrator',
			'username' => 'root@root.ua',
			'password' => md5('root'),
			'first_name' => 'root',
			'last_name' => 'root',
			'sex' => 'm',
		));
		
		$this->insert('users', array(
			'role' => 'moderator',
			'username' => 'moderator@root.ua',
			'password' => md5('moderator'),
			'first_name' => 'moderator',
			'last_name' => 'moderator',
			'sex' => 'f',
		));
		
		$this->insert('users', array(
			'role' => 'editor',
			'username' => 'editor@root.ua',
			'password' => md5('editor'),
			'first_name' => 'editor',
			'last_name' => 'editor',
			'sex' => 'm',
		));
	}

	public function down() {
		$this->dropTable('users');
		return true;
	}

}