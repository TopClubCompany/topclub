<?php

return array(
	'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
	'name' => 'TopClub',
	'language' => 'ru',
	'preload' => array('log'),
	'import' => array(
		'application.models.*',
		'application.components.*',
	),
	'modules' => array(
		'ycm' => array(
			'username' => 'admin',
			'password' => '12345',
			'registerModels' => array(
				'application.models.*',
			),
			'menuItems' => require dirname(__FILE__) . '/_ycm_menu_items.php',
			'uploadCreate' => true,
			'redactorUpload' => true,
			'defaultModel' => 'Places'
		),
	),
	'components' => array(
		'urlManager' => array(
			'urlFormat' => 'path',
			'showScriptName' => false,
			'rules' => array(
				'<controller:\w+>/<id:\d+>' => '<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
				'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
			),
		),
		'db' => array(
			'connectionString' => 'mysql:host=localhost;dbname=topclubyii',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
			'enableProfiling' => true,
			'enableParamLogging' => true,
		),
		'cache'=>array(
            'class'=>'system.caching.CMemCache',
            'servers'=>array(
                //array('host'=>'localost', 'port'=>11211, 'weight'=>60),
                //array('host'=>'localost', 'port'=>11211, 'weight'=>40),
				array('host'=>'localhost', 'port'=>11211),
            ),
			'useMemcached' => true,
        ),
		'errorHandler' => array(
			'errorAction' => 'site/error',
		),
		'log' => array(
			'class' => 'CLogRouter',
			'routes' => array(
				array(
					'class' => 'CFileLogRoute',
					'levels' => 'error, warning',
				),
				array(
					'class' => 'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
				)
			),
		),
		'mailer' => array(
			'class' => 'application.extensions.mailer.EMailer',
			'transportType' => 'smtp',
			'transportOptions' => array(
				'host'=>'smtp.gmail.com',
				'username'=>'tolyamba@topclub.kiev.ua',
				'password'=>'Mykhalkiv89',
				'port'=>'465',
				'encryption'=>'ssl'
			),
			'viewPath' => 'application.views.mail',
			'logging' => true,
			'dryRun' => false
		 ),
	),
	'params' => array(
		'adminEmail' => 'yarikkotsur@gmail.com',
	)
);