<?php

class m130111_094451_create_table_places extends CDbMigration {

	public function up() {
		$this->createTable('places', array(
			'place_id' => 'INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'category_id' => 'INT UNSIGNED DEFAULT NULL',
			'url' => 'VARCHAR(100)',
			'status' => 'BOOLEAN NOT NULL DEFAULT 1',
			'schedule' => 'VARCHAR(50)',
			'street_number' => 'VARCHAR(10)',
			'phones' => 'VARCHAR(255)',
			'admin_phone' => 'INT(10) DEFAULT NULL',
			'website' => 'VARCHAR(100)',
			'email' => 'VARCHAR(100)',
			'cost' => 'SMALLINT(4) DEFAULT 0',
			'lat' => 'FLOAT',
			'lng' => 'FLOAT',
			'order_discount' => 'TINYINT(3) UNSIGNED',
			'order_discount_banket' => 'TINYINT(3) UNSIGNED',
			'closed' => 'BOOLEAN NOT NULL DEFAULT 0',
			'created_at' => 'DATETIME NOT NULL',
			'updated_at' => 'DATETIME NOT NULL',
			'created_by' => 'INT UNSIGNED',
			'updated_by' => 'INT UNSIGNED',
				), 'ENGINE=InnoDB COLLATE=utf8_general_ci');

		$this->createIndex('created_by', 'places', 'created_by');
		$this->createIndex('updated_by', 'places', 'updated_by');
		$this->createIndex('category_id', 'places', 'category_id');
		$this->createIndex('url', 'places', 'url', true);
		$this->addForeignKey('created_by_fk', 'places', 'created_by', 'users', 'user_id', 'CASCADE', 'SET NULL');
		$this->addForeignKey('updated_by_fk', 'places', 'updated_by', 'users', 'user_id', 'CASCADE', 'SET NULL');
	}

	public function down() {
		$this->dropTable('places');
		return true;
	}

}