<?php
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'TopClub Reserve',
	'preload'=>array('log'),
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),
	'modules'=>array(
		'ycm'=>array(
            'username'=>'admin',
            'password'=>'12345',
            'registerModels'=>array(
                'application.models.*',
            ),
            'uploadCreate'=>true, 
            'redactorUpload'=>true,
        ),
	),
	'components'=>array(
		'user'=>array(
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName' => false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=reserveyii',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '1111',
			'charset' => 'utf8',
		),
		'errorHandler'=>array(
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),
	'params'=>array(
		'adminEmail'=>'yarikkotsur@gmail.com',
	),
);