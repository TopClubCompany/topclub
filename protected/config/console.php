<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
	'name' => 'My Console Application',
	// preloading 'log' component
	'preload' => array('log'),
	'import' => array(
		'application.models.*',
		'application.components.*',
	),
	'components' => array(
		'db' => array_merge(array(
			'emulatePrepare' => true,
			'charset' => 'utf8',
				), include(dirname(__FILE__) . DIRECTORY_SEPARATOR . '_main_db.php')),
		'testdb' => CMap::mergeArray(array(
			'class' => 'CDbConnection',
				), require(dirname(__FILE__) . DIRECTORY_SEPARATOR . '_test_db.php')),
		'db2' => array(
			'class' => 'CDbConnection',
			'connectionString' => 'mysql:host=88.198.11.137;dbname=topclub',
			'emulatePrepare' => true,
			'username' => 'topclubuatm',
			'password' => 'BY9EV4WhvADdyGfX',
			'charset' => 'utf8',
		),
		'log' => array(
			'class' => 'CLogRouter',
			'routes' => array(
				array(
					'class' => 'CFileLogRoute',
					'levels' => 'error, warning',
				),
			),
		),
	),
);