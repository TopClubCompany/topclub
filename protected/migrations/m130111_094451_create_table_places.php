<?php

class m130111_094451_create_table_places extends CDbMigration
{
	public function up()
	{
		$this->createTable('places', array(
			'place_id' => 'INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'title' => 'VARCHAR(100)',
			'url_title' => 'VARCHAR(100)',
			'status' => 'ENUM ("open", "closed") NOT NULL',
			'name' => 'VARCHAR(50)',
			'schedule' => 'VARCHAR(50)',
			'place_desc' => 'TEXT',
			'street' => 'VARCHAR(50)',
			'street_number' => 'VARCHAR(10)',
			'place_orientir' => 'VARCHAR(255)',
			'phone' => 'CHAR(16)',
			'phone2' => 'CHAR(16)',
			'admin_phone' => 'INT(10)',
			'website' => 'VARCHAR(100)',
			'email' => 'VARCHAR(100)',
			'cost' => 'TINYINT(4) DEFAULT 0',
			'lat' => 'FLOAT',
			'lng' => 'FLOAT',
			'order_discount' => 'TINYINT(3)',
			'order_discount_banket' => 'TINYINT(3)',
			'search_mistakes' => 'VARCHAR(50)',
			'closed' => 'CHAR(4) DEFAULT "no"',
				), 'ENGINE=InnoDB COLLATE=utf8_general_ci');
	}

	public function down()
	{
		$this->dropTable('places');
		return true;
	}
}