<?php

class m130114_083308_create_table_articles extends CDbMigration
{
	public function up()
	{
		$this->createTable('articles', array(
			'article_id' => 'INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'title' => 'VARCHAR(100)',
			'url' => 'VARCHAR(150)',
			'pub_txt' =>  'TEXT',
			'pub_cover' => 'VARCHAR(150)',
			'sub_header' => 'TEXT',
			'ip_address' => 'VARCHAR(15)',
			'created_at' => 'DATETIME NOT NULL',
			'updated_at' => 'DATETIME NOT NULL',
			'created_by' => 'INT UNSIGNED',
			'updated_by' => 'INT UNSIGNED',
			'status' => 'BOOLEAN NOT NULL DEFAULT 1',
				), 'ENGINE=InnoDB COLLATE=utf8_general_ci');
		$this->createIndex('article_id', 'articles', 'article_id');
	}

	public function down()
	{
		$this->dropTable('articles');
		return true;
	}
}