<?php

class m121214_154618_table_languages_add_columns extends CDbMigration {

	public function up() {
		$this->addColumn('languages', 'enabled', 'BOOLEAN NOT NULL DEFAULT TRUE');
		$this->addColumn('languages', 'default', 'BOOLEAN NOT NULL DEFAULT FALSE');
	}

	public function down() {
		$this->dropColumn('languages', 'enabled');
		$this->dropColumn('languages', 'default');
		return true;
	}
}