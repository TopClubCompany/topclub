<?php

class YcmLoginTest extends WebTestCase {

	public $fixtures = array(
		'users' => 'UsersModel',
	);

	public function testIndex() {
		$this->open('ycm');
		$this->assertTextPresent(Yii::t('YcmModule.ycm', 'Please enter your username and password.'));
		$this->assertTextPresent(Yii::t('YcmModule.ycm', 'Remember me next time'));
	}

	public function testLogin() {
		$this->open('ycm');
		$this->assertElementPresent('name=LoginForm[username]');
		$this->type('name=LoginForm[username]', $this->users['administrator']['username']);
		$this->assertElementPresent('name=LoginForm[password]');
		$this->type('name=LoginForm[password]', 'wrongpassword');
		$this->assertElementPresent('css=button[type=submit]');
		$this->clickAndWait('css=button[type=submit]');
		$this->assertTextPresent(Yii::t('YcmModule.ycm', 'Incorrect username or password.'));
		$this->loginAdministrator();
		$this->assertTextNotPresent(Yii::t('YcmModule.ycm', 'Incorrect username or password.'));
		$this->assertElementPresent('css=a[href="/' . TEST_INDEX_FILE . '/ycm/default/logout"]');
	}

	public function testLogout() {
		$this->loginAdministrator();
		$this->assertLocation(TEST_BASE_URL . 'ycm');
		$this->clickAndWait('css=a[href="/' . TEST_INDEX_FILE . '/ycm/default/logout"]');
		$this->assertLocation(TEST_BASE_URL . 'ycm/default/login');
		$this->assertTextPresent(Yii::t('YcmModule.ycm', 'Please enter your username and password.'));
		$this->assertTextPresent(Yii::t('YcmModule.ycm', 'Remember me next time'));
	}

	/* public function testContact() {
	  $this->open('?r=site/contact');
	  $this->assertTextPresent('Contact Us');
	  $this->assertElementPresent('name=ContactForm[name]');

	  $this->type('name=ContactForm[name]', 'tester');
	  $this->type('name=ContactForm[email]', 'tester@example.com');
	  $this->type('name=ContactForm[subject]', 'test subject');
	  $this->click("//input[@value='Submit']");
	  $this->waitForTextPresent('Body cannot be blank.');
	  }

	  public function testLoginLogout() {
	  $this->open('');
	  // ensure the user is logged out
	  if ($this->isTextPresent('Logout'))
	  $this->clickAndWait('link=Logout (demo)');

	  // test login process, including validation
	  $this->clickAndWait('link=Login');
	  $this->assertElementPresent('name=LoginForm[username]');
	  $this->type('name=LoginForm[username]', 'demo');
	  $this->click("//input[@value='Login']");
	  $this->waitForTextPresent('Password cannot be blank.');
	  $this->type('name=LoginForm[password]', 'demo');
	  $this->clickAndWait("//input[@value='Login']");
	  $this->assertTextNotPresent('Password cannot be blank.');
	  $this->assertTextPresent('Logout');

	  // test logout process
	  $this->assertTextNotPresent('Login');
	  $this->clickAndWait('link=Logout (demo)');
	  $this->assertTextPresent('Login');
	  } */
}
