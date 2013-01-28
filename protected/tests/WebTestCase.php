<?php

define('TEST_INDEX_FILE', 'index-test.php');
define('TEST_BASE_URL', 'http://topclub.loc/' . TEST_INDEX_FILE . '/');


class WebTestCase extends CWebTestCase {

	protected function setUp() {
		parent::setUp();
		Yii::import('application.modules.ycm.YcmModule');
		$this->setBrowserUrl(TEST_BASE_URL);
		$this->setBrowser('*firefox');
	}
	
	public function loginAdministrator() {
		$this->open('ycm');
		$this->type('name=LoginForm[username]', $this->users['administrator']['username']);
		$this->type('name=LoginForm[password]', 'administrator');
		$this->clickAndWait('css=button[type=submit]');
	}
	
	/*public static function t($category, $message, $params = null, $source = null, $language = null) {
		Yii::t('application.modules.ycm.'$category, $message, $params, $source, $language)
	}*/

}