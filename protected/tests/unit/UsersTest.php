<?php

class UsersTest extends CDbTestCase {
	
	public $fixtures = array(
		'users' => 'UsersModel',
	);

	public function testChecnkInsertedUsers() {
		$user = UsersModel::model()->findByPk(1);
		$this->assertTrue($user instanceof UsersModel);
	}

}