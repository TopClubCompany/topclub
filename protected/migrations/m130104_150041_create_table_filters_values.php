<?php

class m130104_150041_create_table_filters_values extends CDbMigration {

	public function up() {
		$this->createTable('filters_values', array(
			'value_id' => 'INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'filter_id' => 'INT UNSIGNED NOT NULL',
			'url' => 'VARCHAR(50) NOT NULL'
				), 'ENGINE=InnoDB COLLATE=utf8_general_ci');

		$this->createIndex('filter_id', 'filters_values', 'filter_id');
		$this->createIndex('filter_id_url', 'filters_values', 'filter_id,url', true);

		//error find wtf?
		//$this->addForeignKey('filter_id_fk', 'filters_values', 'filter_id', 'filters', 'filter_id', 'CASCADE', 'CASCADE');

		$this->insert('filters_values', array(
			'value_id' => 1,
			'filter_id' => 1,
			'url' => 'chinese'
		));
		
		$this->insert('filters_values', array(
			'value_id' => 2,
			'filter_id' => 1,
			'url' => 'italian'
		));
		
		$this->insert('filters_values', array(
			'value_id' => 3,
			'filter_id' => 1,
			'url' => 'ukrainian'
		));
		
		$this->insert('filters_values', array(
			'value_id' => 4,
			'filter_id' => 1,
			'url' => 'korean'
		));
		
		$this->insert('filters_values', array(
			'value_id' => 5,
			'filter_id' => 2,
			'url' => 'very-cheap'
		));
		
		$this->insert('filters_values', array(
			'value_id' => 6,
			'filter_id' => 2,
			'url' => 'cheap'
		));
		
		$this->insert('filters_values', array(
			'value_id' => 7,
			'filter_id' => 2,
			'url' => 'middle-price'
		));
		
		$this->insert('filters_values', array(
			'value_id' => 8,
			'filter_id' => 2,
			'url' => 'expensive'
		));
	}

	public function down() {
		$this->dropTable('filters_values');
		return true;
	}

}
