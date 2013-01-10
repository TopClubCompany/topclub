<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
	'name' => 'My Console Application',
	// preloading 'log' component
	'preload' => array('log'),
	// application components
	'components' => array(
		'db' => array_merge(array(
			'emulatePrepare' => true,
			'charset' => 'utf8',
				), include(dirname(__FILE__) . DIRECTORY_SEPARATOR . '_main_db.php')),
		'db2' => array(
			'class' => 'CDbConnection',
			'connectionString' => 'mysql:host=89.184.69.32;dbname=topclub_3',
			'emulatePrepare' => true,
			'username' => 'u_sequel_pro',
			'password' => '900dBrPP',
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