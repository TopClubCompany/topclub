<?php

class m121214_154618_table_languages_add_columns extends CDbMigration {

	public function up() {
		$this->addColumn('languages', 'enable', 'BOOLEAN NOT NULL DEFAULT TRUE');
		$this->addColumn('languages', 'dafault', 'BOOLEAN NOT NULL DEFAULT FALSE');
	}

	public function down() {
		$this->dropColumn('languages', 'enable');
		$this->dropColumn('languages', 'dafault');
		return true;
	}
}