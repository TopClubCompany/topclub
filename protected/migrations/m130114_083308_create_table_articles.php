<?php

class m130114_083308_create_table_articles extends CDbMigration
{
	public function up()
	{
		$this->createTable('articles', array(
			'article_id' => 'INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'author_id' => 'INT UNSIGNED NOT NULL',
			'title' => 'VARCHAR(100)',
			'url_title' => 'VARCHAR(150)',
			'pub_txt' =>  'TEXT',
			'pub_image' => 'VARCHAR(150)',
			'sub_header' => 'TEXT',
			'video_type' => 'VARCHAR(50)',
			'ip_address' => 'VARCHAR(15)',
			'pub_date' => 'DATE',
			'status' => 'ENUM ("open", "closed") NOT NULL',
				), 'ENGINE=InnoDB COLLATE=utf8_general_ci');
	}

	public function down()
	{
		$this->dropTable('articles');
		return true;
	}
}