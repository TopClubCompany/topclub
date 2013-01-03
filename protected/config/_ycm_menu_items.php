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
			),
			array(
				'label' => 'Фильтры',
				//'url' => array('Filters/index'),
				'items' => array(
					array(
						'label' => 'Все фильтры',
						'url' => array('Filters/index'),
					),
					array(
						'label' => 'Добавить фильтр',
						'url' => array('Filters/add'),
					),
				)
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