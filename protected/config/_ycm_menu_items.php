<?php

return array(
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
);