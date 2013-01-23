<?php

return array(
	array(
		'label' => 'Каталог',
		'items' => array(
			array(
				'label' => 'Места',
				'url' => array('Places/index')
			),
			array(
				'label' => 'Категории',
				'url' => array('PlacesCategories/index')
			),
			array(
				'label' => 'Альбомы',
				'url' => array('Albums/index')
			),
			array(
				'label' => 'Фильтры',
				'items' => array(
					array(
						'label' => 'Все фильтры',
						'url' => array('Filters/index'),
					),
					array(
						'label' => 'Добавить фильтр',
						'url' => array('Filters/add'),
					),
					array(
						'label' => 'Все свойства фильтров',
						'url' => array('FiltersValues/index'),
					),
					array(
						'label' => 'Добавить свойство фильтра',
						'url' => array('FiltersValues/add'),
					),
				)
			),
			array(
				'label' => 'Комментарии',
				'url' => array('Comments/index')
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
			),
			array(
				'label' => 'Мой профиль',
				'url' => array('profile/edit')
			)
		)		
	),
	array(
		'label' => 'Пользователи',
		'url' => '#',
		'items' => array(
			array(
				'label' => 'Все',
				'url' => array('users/index')
			),
			array(
				'label' => 'Добавить',
				'url' => array('users/add')
			)
		)		
	),
);