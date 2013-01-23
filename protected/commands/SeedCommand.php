<?php

class SeedCommand extends CConsoleCommand {

	public function actionHelp() {
		echo $this->help;
	}

	public function actionIndex() {
		$this->actionLanguages();
		$this->actionUsers();
		$this->actionFilters();
	}

	public function actionLanguages() {
		$command = Yii::app()->db->createCommand();

		echo "Insert tests languages ...\n";
		$command->insert('languages', array(
			'language_id' => 1,
			'code' => 'ru',
			'name' => 'Русский',
			'default' => 1,
			'enabled' => 1
		));

		$command->insert('languages', array(
			'language_id' => 2,
			'code' => 'ua',
			'name' => 'Українська',
			'default' => 0,
			'enabled' => 1
		));

		$command->insert('languages', array(
			'language_id' => 3,
			'code' => 'en',
			'name' => 'English',
			'default' => 0,
			'enabled' => 1
		));
	}

	public function actionUsers() {
		$command = Yii::app()->db->createCommand();

		$command->insert('users', array(
			'role' => 'root',
			'username' => 'root@root.ua',
			'password' => md5('root'),
			'first_name' => 'root',
			'last_name' => 'root',
			'sex' => 'm',
		));

		$command->insert('users', array(
			'role' => 'editor',
			'username' => 'editor@root.ua',
			'password' => md5('editor'),
			'first_name' => 'editor',
			'last_name' => 'editor',
			'sex' => 'm',
		));
	}

	public function actionFilters() {

		$command = Yii::app()->db->createCommand();

		echo "Insert tests filters ...\n";
		$command->insert('filters', array(
			'filter_id' => 1,
			'url' => 'kitchens'
		));

		$command->insert('filters', array(
			'filter_id' => 2,
			'url' => 'price'
		));

		echo "Insert tests filters_desc ...\n";
		$command->insert('filters_desc', array(
			'filter_id' => 1,
			'language_id' => 1,
			'name' => 'Кухни',
			'description' => 'Кухни'
		));

		$command->insert('filters_desc', array(
			'filter_id' => 1,
			'language_id' => 2,
			'name' => 'Кухні',
			'description' => 'Кухні'
		));

		$command->insert('filters_desc', array(
			'filter_id' => 1,
			'language_id' => 3,
			'name' => 'Kitchens',
			'description' => 'Kitchens'
		));

		$command->insert('filters_desc', array(
			'filter_id' => 2,
			'language_id' => 1,
			'name' => 'Цена',
			'description' => 'Цена'
		));

		$command->insert('filters_desc', array(
			'filter_id' => 2,
			'language_id' => 2,
			'name' => 'Ціна',
			'description' => 'Ціна'
		));

		$command->insert('filters_desc', array(
			'filter_id' => 2,
			'language_id' => 3,
			'name' => 'Price',
			'description' => 'Price'
		));

		echo "Insert tests filters_values ...\n";
		$command->insert('filters_values', array(
			'value_id' => 1,
			'filter_id' => 1,
			'url' => 'chinese'
		));

		$command->insert('filters_values', array(
			'value_id' => 2,
			'filter_id' => 1,
			'url' => 'italian'
		));

		$command->insert('filters_values', array(
			'value_id' => 3,
			'filter_id' => 1,
			'url' => 'ukrainian'
		));

		$command->insert('filters_values', array(
			'value_id' => 4,
			'filter_id' => 1,
			'url' => 'korean'
		));

		$command->insert('filters_values', array(
			'value_id' => 5,
			'filter_id' => 2,
			'url' => 'very-cheap'
		));

		$command->insert('filters_values', array(
			'value_id' => 6,
			'filter_id' => 2,
			'url' => 'cheap'
		));

		$command->insert('filters_values', array(
			'value_id' => 7,
			'filter_id' => 2,
			'url' => 'middle-price'
		));

		$command->insert('filters_values', array(
			'value_id' => 8,
			'filter_id' => 2,
			'url' => 'expensive'
		));

		echo "Insert tests filters_values_desc ...\n";
		$command->insert('filters_values_desc', array(
			'value_id' => 1,
			'language_id' => 1,
			'name' => 'Китайская'
		));

		$command->insert('filters_values_desc', array(
			'value_id' => 1,
			'language_id' => 2,
			'name' => 'Китайська'
		));

		$command->insert('filters_values_desc', array(
			'value_id' => 1,
			'language_id' => 3,
			'name' => 'Chinese'
		));

		$command->insert('filters_values_desc', array(
			'value_id' => 2,
			'language_id' => 1,
			'name' => 'Итальянская'
		));

		$command->insert('filters_values_desc', array(
			'value_id' => 2,
			'language_id' => 2,
			'name' => 'Італіська'
		));

		$command->insert('filters_values_desc', array(
			'value_id' => 2,
			'language_id' => 3,
			'name' => 'Italian'
		));

		$command->insert('filters_values_desc', array(
			'value_id' => 3,
			'language_id' => 1,
			'name' => 'Украинская'
		));

		$command->insert('filters_values_desc', array(
			'value_id' => 3,
			'language_id' => 2,
			'name' => 'Українська'
		));

		$command->insert('filters_values_desc', array(
			'value_id' => 3,
			'language_id' => 3,
			'name' => 'Ukrainian'
		));

		$command->insert('filters_values_desc', array(
			'value_id' => 4,
			'language_id' => 1,
			'name' => 'Корейская'
		));

		$command->insert('filters_values_desc', array(
			'value_id' => 4,
			'language_id' => 2,
			'name' => 'Корейська'
		));

		$command->insert('filters_values_desc', array(
			'value_id' => 4,
			'language_id' => 3,
			'name' => 'Korean'
		));

		$command->insert('filters_values_desc', array(
			'value_id' => 5,
			'language_id' => 1,
			'name' => 'Очень дешево'
		));

		$command->insert('filters_values_desc', array(
			'value_id' => 5,
			'language_id' => 2,
			'name' => 'Дуже дешево'
		));

		$command->insert('filters_values_desc', array(
			'value_id' => 5,
			'language_id' => 3,
			'name' => 'Very cheap'
		));

		$command->insert('filters_values_desc', array(
			'value_id' => 6,
			'language_id' => 1,
			'name' => 'Дешево'
		));

		$command->insert('filters_values_desc', array(
			'value_id' => 6,
			'language_id' => 2,
			'name' => 'Дешево'
		));

		$command->insert('filters_values_desc', array(
			'value_id' => 6,
			'language_id' => 3,
			'name' => 'Сheap'
		));

		$command->insert('filters_values_desc', array(
			'value_id' => 7,
			'language_id' => 1,
			'name' => 'Середняя'
		));

		$command->insert('filters_values_desc', array(
			'value_id' => 7,
			'language_id' => 2,
			'name' => 'Средняя'
		));

		$command->insert('filters_values_desc', array(
			'value_id' => 7,
			'language_id' => 3,
			'name' => 'Middle price'
		));

		$command->insert('filters_values_desc', array(
			'value_id' => 8,
			'language_id' => 1,
			'name' => 'Дорого'
		));

		$command->insert('filters_values_desc', array(
			'value_id' => 8,
			'language_id' => 2,
			'name' => 'Дорого'
		));

		$command->insert('filters_values_desc', array(
			'value_id' => 8,
			'language_id' => 3,
			'name' => 'Expensive'
		));
	}

}	