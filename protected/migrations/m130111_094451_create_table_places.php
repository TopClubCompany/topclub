<?php

class m130111_094451_create_table_places extends CDbMigration
{
	public function up()
	{
		$this->createTable('places', array(
			'place_id' => 'INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
			//'title' => 'VARCHAR(100)',
			'url' => 'VARCHAR(100)',
			'status' => 'BOOLEAN NOT NULL DEFAULT 1',
			//'name' => 'VARCHAR(50)',
			'schedule' => 'VARCHAR(50)',
			//'place_desc' => 'TEXT',
			//'street' => 'VARCHAR(50)',
			'street_number' => 'VARCHAR(10)',
			//'place_orientir' => 'VARCHAR(255)',
			'phones' => 'VARCHAR(255)',
			'admin_phone' => 'INT(10) DEFAULT NULL',
			'website' => 'VARCHAR(100)',
			'email' => 'VARCHAR(100)',
			'cost' => 'SMALLINT(4) DEFAULT 0',
			'lat' => 'FLOAT',
			'lng' => 'FLOAT',
			'order_discount' => 'TINYINT(3) UNSIGNED',
			'order_discount_banket' => 'TINYINT(3) UNSIGNED',
			//'search_mistakes' => 'VARCHAR(50)',
			'closed' => 'BOOLEAN NOT NULL DEFAULT 0',
				), 'ENGINE=InnoDB COLLATE=utf8_general_ci');
	}

	public function down()
	{
		$this->dropTable('places');
		return true;
	}
}