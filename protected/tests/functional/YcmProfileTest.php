<?php

/**
 * Description of YcmProfileTest
 *
 * @author shults
 */
class YcmProfileTest extends WebTestCase {

	public $fixtures = array(
		'users' => 'UsersModel',
	);

	public function testEdit() {
		$this->loginAdministrator();
		$this->open('ycm/profile/edit');
		$this->assertElementPresent('UsersModel[password]');
		$this->assertElementPresent('UsersModel[password_repeat]');
		$this->type('UsersModel[password]', 'new_password');
		$this->type('UsersModel[password_repeat]', 'new_password_error');
		$this->clickAndWait('css=button[name=_update]');
		$this->assertTextPresent(Yii::t('YcmModule.profile', 'Password must be repeated exactly.'));
		$this->type('UsersModel[password]', 'new_password');
		$this->type('UsersModel[password_repeat]', 'new_password');
		$this->clickAndWait('css=button[name=_update]');
		$this->assertLocation(TEST_BASE_URL . 'ycm/profile/edit');
		$administrator = UsersModel::model()->find('username=:username', array(':username' => $this->users['administrator']['username']));
		$this->assertTrue($administrator instanceof UsersModel);
		$this->assertTrue($administrator->password == sha1('new_password'));
		//rollbackchanges
		$administrator->password = 'administrator';
		$administrator->password_repeat = 'administrator';
		$administrator->setScenario('profile_update');
		$this->assertTrue($administrator->save());
	}

}