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
			'menuItems' => array(
				array(
					'label' => 'Каталог',
					'items' => array(
						array(
							'label' => 'Места',
							'model' => 'Places'
						),
						array(
							'label' => 'Категории',
							'url' => array('PlacesCategories/index')
						)
					)
				),
				array(
					'label' => 'Настройки',
					'url' => '#',
					'items' => array(
						array(
							'label' => 'Языки',
							'url' => array('Languages/index')
						)
					)
				),
			),
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
			'password' => '1111',
			'charset' => 'utf8',
			'enableProfiling' => true,
			'enableParamLogging' => true,
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
	),
	'params' => array(
		'adminEmail' => 'yarikkotsur@gmail.com',
	),
);