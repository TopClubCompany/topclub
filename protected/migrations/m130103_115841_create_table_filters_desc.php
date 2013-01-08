<?php

class m130103_115841_create_table_filters_desc extends CDbMigration {

	public function up() {
		$this->createTable('filters_desc', array(
			'filter_id' => 'INT UNSIGNED NOT NULL',
			'language_id' => 'SMALLINT UNSIGNED NOT NULL',
			'name' => 'VARCHAR(50) NOT NULL',
			'description' => 'TEXT'
		));
		$this->createIndex('filter_id_language_id', 'filters_desc', 'filter_id,language_id', true);

		$this->createIndex('filter_id', 'filters_desc', 'filter_id');
		$this->createIndex('language_id', 'filters_desc', 'language_id');

		$this->addForeignKey('filter_id_fk', 'filters_desc', 'filter_id', 'filters', 'filter_id', 'CASCADE', 'CASCADE');

		$this->addForeignKey('language_id_fk', 'filters_desc', 'language_id', 'languages', 'language_id', 'CASCADE', 'CASCADE');
		
		$this->insert('filters_desc', array(
			'filter_id' => 1,
			'language_id' => 1,
			'name' => 'Кухни',
			'description' => 'Кухни'
		));
		
		$this->insert('filters_desc', array(
			'filter_id' => 1,
			'language_id' => 2,
			'name' => 'Кухні',
			'description' => 'Кухні'
		));
		
		$this->insert('filters_desc', array(
			'filter_id' => 1,
			'language_id' => 3,
			'name' => 'Kitchens',
			'description' => 'Kitchens'
		));
		
		$this->insert('filters_desc', array(
			'filter_id' => 1,
			'language_id' => 4,
			'name' => 'jkafjkahsdfjhajkl',
			'description' => 'jhdfskl;hafhajklh'
		));
		
		$this->insert('filters_desc', array(
			'filter_id' => 2,
			'language_id' => 1,
			'name' => 'Цена',
			'description' => 'Цена'
		));
		
		$this->insert('filters_desc', array(
			'filter_id' => 2,
			'language_id' => 2,
			'name' => 'Ціна',
			'description' => 'Ціна'
		));
		
		$this->insert('filters_desc', array(
			'filter_id' => 2,
			'language_id' => 3,
			'name' => 'Price',
			'description' => 'Price'
		));
		
		$this->insert('filters_desc', array(
			'filter_id' => 2,
			'language_id' => 4,
			'name' => 'jkafjkahsdfjhajkl',
			'description' => 'jhdfskl;hafhajklh'
		));
	}

	public function down() {
		$this->dropTable('filters_desc');
		return true;
	}
}