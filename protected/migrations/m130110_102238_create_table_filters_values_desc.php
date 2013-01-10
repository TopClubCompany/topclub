<?php

class m130110_102238_create_table_filters_values_desc extends CDbMigration {

	public function up() {
		$this->createTable('filters_values_desc', array(
			'value_id' => 'INT UNSIGNED NOT NULL',
			'language_id' => 'SMALLINT UNSIGNED NOT NULL',
			'name' => 'VARCHAR(50) NOT NULL',
			'description' => 'TEXT'
		), 'ENGINE=InnoDB COLLATE=utf8_general_ci');
		
		$this->createIndex('value_id', 'filters_values_desc', 'value_id');
		$this->createIndex('language_id', 'filters_values_desc', 'language_id');
		
		$this->insert('filters_values_desc', array(
			'value_id' => 1,
			'language_id' => 1,
			'name' => 'Китайская'
		));
		
		$this->insert('filters_values_desc', array(
			'value_id' => 1,
			'language_id' => 2,
			'name' => 'Китайська'
		));
		
		$this->insert('filters_values_desc', array(
			'value_id' => 1,
			'language_id' => 3,
			'name' => 'Chinese'
		));
		
		$this->insert('filters_values_desc', array(
			'value_id' => 2,
			'language_id' => 1,
			'name' => 'Итальянская'
		));
		
		$this->insert('filters_values_desc', array(
			'value_id' => 2,
			'language_id' => 2,
			'name' => 'Італіська'
		));
		
		$this->insert('filters_values_desc', array(
			'value_id' => 2,
			'language_id' => 3,
			'name' => 'Italian'
		));
		
		$this->insert('filters_values_desc', array(
			'value_id' => 3,
			'language_id' => 1,
			'name' => 'Украинская'
		));
		
		$this->insert('filters_values_desc', array(
			'value_id' => 3,
			'language_id' => 2,
			'name' => 'Українська'
		));
		
		$this->insert('filters_values_desc', array(
			'value_id' => 3,
			'language_id' => 3,
			'name' => 'Ukrainian'
		));
		
		$this->insert('filters_values_desc', array(
			'value_id' => 4,
			'language_id' => 1,
			'name' => 'Корейская'
		));
		
		$this->insert('filters_values_desc', array(
			'value_id' => 4,
			'language_id' => 2,
			'name' => 'Корейська'
		));
		
		$this->insert('filters_values_desc', array(
			'value_id' => 4,
			'language_id' => 3,
			'name' => 'Korean'
		));
		
		$this->insert('filters_values_desc', array(
			'value_id' => 5,
			'language_id' => 1,
			'name' => 'Очень дешево'
		));
		
		$this->insert('filters_values_desc', array(
			'value_id' => 5,
			'language_id' => 2,
			'name' => 'Дуже дешево'
		));
		
		$this->insert('filters_values_desc', array(
			'value_id' => 5,
			'language_id' => 3,
			'name' => 'Very cheap'
		));
		
		$this->insert('filters_values_desc', array(
			'value_id' => 6,
			'language_id' => 1,
			'name' => 'Дешево'
		));
		
		$this->insert('filters_values_desc', array(
			'value_id' => 6,
			'language_id' => 2,
			'name' => 'Дешево'
		));
		
		$this->insert('filters_values_desc', array(
			'value_id' => 6,
			'language_id' => 3,
			'name' => 'Сheap'
		));
		
		$this->insert('filters_values_desc', array(
			'value_id' => 7,
			'language_id' => 1,
			'name' => 'Середняя'
		));
		
		$this->insert('filters_values_desc', array(
			'value_id' => 7,
			'language_id' => 2,
			'name' => 'Средняя'
		));
		
		$this->insert('filters_values_desc', array(
			'value_id' => 7,
			'language_id' => 3,
			'name' => 'Middle price'
		));
		
		$this->insert('filters_values_desc', array(
			'value_id' => 8,
			'language_id' => 1,
			'name' => 'Дорого'
		));
		
		$this->insert('filters_values_desc', array(
			'value_id' => 8,
			'language_id' => 2,
			'name' => 'Дорого'
		));
		
		$this->insert('filters_values_desc', array(
			'value_id' => 8,
			'language_id' => 3,
			'name' => 'Expensive'
		));
	}

	public function down() {
		$this->dropTable('filters_values_desc');
		return true;
	}

}