<?php

return CMap::mergeArray(
				require(dirname(__FILE__) . '/main.php'), array(
			'components' => array(
				'fixture' => array(
					'class' => 'system.test.CDbFixtureManager',
					//'basePath' => dirname(__FILE__) . '/../tests/fixtures',
				),
				'db' => CMap::mergeArray(array(
					'class' => 'CDbConnection',
						), require(dirname(__FILE__) . DIRECTORY_SEPARATOR . '_test_db.php')),
			),
				)
);
