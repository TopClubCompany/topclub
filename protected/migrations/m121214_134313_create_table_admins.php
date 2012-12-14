<?php

class m121214_134313_create_table_admins extends CDbMigration {

	public function up() {
		$this->createTable('admins', array(
			'admin_id' => 'SMALLINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
			'username' => 'VARCHAR(50) NOT NULL UNIQUE',
			'password' => 'CHAR(40) NOT NULL',
			'phone' => 'VARCHAR(20)',
			'first_name' => 'VARCHAR(50)',
			'last_name' => 'VARCHAR(50)'
		), 'ENGINE=INNODB COLLATE=utf8_general_ci');
	}

	public function down() {
		$this->dropTable('admins');
		echo "Таблица admins удалена\n";
		return true;
	}
}