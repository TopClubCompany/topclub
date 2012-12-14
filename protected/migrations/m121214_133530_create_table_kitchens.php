<?php

class m121214_133530_create_table_kitchens extends CDbMigration {

	public function up() {
		$this->createTable('kitchens', array(
			'kitchen_id' => 'SMALLINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
			'slug' => 'VARCHAR(100) NOT NULL',
		), 'ENGINE=INNODB COLLATE=utf8_general_ci');
	}

	public function down() {
		$this->dropTable('kitchens');
		echo "Таблица kitchens удалена\n";
		return true;
	}
}