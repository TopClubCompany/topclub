<?php

class m121214_120753_create_table_places extends CDbMigration {

	public function up() {
		$this->createTable('places', array(
			'place_id' => 'INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
			'slug' => 'VARCHAR(100) NOT NULL',
			'created_by' => 'SMALLINT UNSIGNED NOT NULL',
			'edited_by' => 'SMALLINT UNSIGNED NOT NULL',
			'phone' => 'VARCHAR(20) NOT NULL',
			'url' => 'VARCHAR(100)',
			'avg_bill' => 'SMALLINT',
			'created_at' => 'DATETIME',
			'updated_at' => 'DATETIME'
		), null);
		
		$this->createIndex('slug', 'places', 'slug', true);
		$this->createIndex('created_at', 'places', 'created_at');
		$this->createIndex('updated_at', 'places', 'updated_at');
	}

	public function down() {
		$this->dropTable('places');
		echo "Таблица places удалена\n";
		return true;
	}

}