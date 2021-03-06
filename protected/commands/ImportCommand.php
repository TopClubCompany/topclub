<?php

class ImportCommand extends CConsoleCommand {

	public function actionHelp() {
		echo $this->help;
	}

	public function actionAll() {
		$this->actionDefault();
		$this->actionUsers();
		$this->actionPlaces();
	}

	public function actionDefault() {
		echo "Insert tests languages ...\n";

		$command = Yii::app()->db->createCommand();

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

	public function actionUsers() {
		$q = "SELECT em.member_id, em.facebook_connect_user_id, em.vk_id, em.group_id,  em.password, em.email, em.location, em.bday_d, em.bday_m, em.bday_y, em.avatar_filename, em.photo_filename, em.ip_address, em.join_date, emd.m_field_id_1 AS twitter, emd.m_field_id_3 AS sex, emd.m_field_id_4 AS last_name, emd.m_field_id_6 AS about_tc, emd.m_field_id_7 AS status, emd.m_field_id_9 AS facebook, emd.m_field_id_10 AS city, emd.m_field_id_11 AS vkontakte, emd.m_field_id_12 AS phone, emd.m_field_id_15 AS first_name FROM  `exp_members` AS em JOIN exp_member_data AS emd ON em.member_id=emd.member_id WHERE rest_discounts != 1 ORDER BY em.member_id";
		$users = Yii::app()->db2->createCommand($q)->queryAll();
		$i = 0;
		echo "Begin importing users ...\n";
		foreach ($users as $user) {
			if (!$first_name = $user['first_name'])
				$first_name = '-';
			if (!$last_name = $user['last_name'])
				$last_name = '-';
			if (!$sex = $user['sex'])
				$sex = '-';
			if (!$tw = $user['twitter'])
				$tw = null;
			if (!$vk = $user['vk_id'])
				$vk = null;
			if (!$fb = $user['facebook_connect_user_id'])
				$fb = null;

			if (UsersModel::model()->find('username=:username', array(':username' => $user['email']))) {
				continue;
			} else if (UsersModel::model()->find('fb_id=:fb_id', array(':fb_id' => $user['facebook_connect_user_id']))) {
				continue;
			} else {
				$command = Yii::app()->db->createCommand();
				$command->insert('users', array(
					'user_id' => $user['member_id'],
					'role' => 'user',
					'username' => $user['email'],
					'first_name' => $first_name,
					'last_name' => $last_name,
					'password' => $user["password"],
					'photo_file_name' => $user["photo_filename"],
					'phone' => $user["phone"],
					'location' => $user["location"],
					'vk_id' => $vk,
					'fb_id' => $fb,
					'birth' => $user["bday_y"] . "-" . $user["bday_m"] . "-" . $user["bday_d"],
					'sex' => $sex,
					'ip_address' => $user["ip_address"],
					'join_date' => $user["join_date"],
					'status' => $user["status"]
				));
				$i++;
				echo "User #{$i} imported\n";
			}
		}
		echo "END importing users!!!\n";
	}

	public function actionKitchens() {
		$q = "SELECT `cat_id`, `cat_name`, `cat_url_title`, `cat_description` FROM `exp_categories` WHERE `group_id` = 9 ORDER BY cat_id";
		$kitchens = Yii::app()->db2->createCommand($q)->queryAll();
		$i = 0;
		echo "Begin importing users ...\n";
		$command = Yii::app()->db->createCommand();
		foreach ($kitchens as $kitchen) {
			$command->insert('filters_values', array(
				'value_id' => $kitchen['cat_id'],
				'filter_id' => 1,
				'url' => $kitchen['cat_url_title']
			));
			//$id = Yii::app()->db->getLastInsertID();
			$command->insert('filters_values_desc', array(
				'value_id' => $kitchen['cat_id'],
				'language_id' => 1,
				'name' => $kitchen['cat_name'],
				'description' => $kitchen['cat_description']
			));
			$i++;
			echo "Kitchen #{$i} imported\n";
		}
		echo "END importing kitchens!!!\n";
	}

	public function actionPlaces() {
		$q = "SELECT ect.entry_date as created_at, author_id as author_id, ecd.entry_id, title, url_title, status, field_id_1 AS name, field_id_2 AS schedule, field_id_3 AS place_desc, field_id_4 AS street, field_id_5 AS street_number, field_id_6 AS place_orientir, field_id_8 AS phone, field_id_9 AS phone2, field_id_11 AS website, field_id_12 AS email, field_id_13 AS cost, field_id_14 AS photo1, field_id_15 AS photo2, field_id_16 AS photo3, field_id_17 AS photo4, field_id_18 AS photo5, field_id_25 AS search_mistakes, field_id_89 AS closed, field_id_96 AS photo6, field_id_97 AS photo7, field_id_98 AS photo8, field_id_99 AS photo9, field_id_100 AS photo10, field_id_108 AS admin_phone,field_id_109 AS order_discount, field_id_110 AS order_discount_banket, field_id_111 AS lat, field_id_112 AS lng FROM exp_channel_data AS ecd JOIN exp_channel_titles AS ect ON ecd.entry_id = ect.entry_id WHERE ecd.channel_id = 1 ORDER BY ecd.entry_id";
		$places = Yii::app()->db2->createCommand($q)->queryAll();
		$i = 0;
		echo "Begin importing places ...\n";
		$command = Yii::app()->db->createCommand();
		foreach ($places as $place) {
			if (!UsersModel::model()->findByPk($place['author_id']))
				continue;
			
			$place['phone'] = str_replace(array('(', ')', '-', ' ', '+'), '', $place['phone']);
			$place['phone2'] = str_replace(array('(', ')', '-', ' ', '+'), '', $place['phone2']);
			$phones = $place['phone'] ? : null;
			if ($place['phone2'] && $phones) {
				$phones .= ',' . $place['phone2'];
			}

			$command->insert('places', array(
				'place_id' => $place['entry_id'],
				'category_id' => null,
				'url' => $place['url_title'],
				'status' => $place['status'] == 'open' ? 1 : 0,
				'schedule' => $place['schedule'],
				'street_number' => $place['street_number'],
				'phones' => $phones,
				'admin_phone' => $place['admin_phone'] == 0 ? null : $place['admin_phone'],
				'website' => $place['website'],
				'email' => $place['email'],
				'cost' => (int) $place['cost'] ? : null,
				'lat' => $place['lat'],
				'lng' => $place['lng'],
				'order_discount' => (int) $place['order_discount'] ? : null,
				'order_discount_banket' => (int) $place['order_discount_banket'] ? : null,
				'closed' => $place['closed'] == 'yes' ? 1 : 0,
				'created_at' => $created_at = date('Y-d-m h:i:s', $place['created_at']),
				'updated_at' => $created_at,
				'created_by' => $place['author_id'],
				'updated_by' => $place['author_id'],
			));

			$command->insert('places_desc', array(
				'place_id' => $place['entry_id'],
				'language_id' => 1,
				'title' => str_replace(array('(Закрыт)', 'Закрыт', 'закрыт'), '', $place['title']),
				'place_desc' => $place['place_desc'],
				'street' => $place['street'],
				'place_orientir' => $place['place_orientir'],
				'search_mistakes' => $place['search_mistakes']
			));

			$command->insert('places_desc', array(
				'place_id' => $place['entry_id'],
				'language_id' => 2,
				'title' => '',
				'place_desc' => '',
				'street' => '',
				'place_orientir' => '',
				'search_mistakes' => ''
			));

			$command->insert('places_desc', array(
				'place_id' => $place['entry_id'],
				'language_id' => 3,
				'title' => '',
				'place_desc' => '',
				'street' => '',
				'place_orientir' => '',
				'search_mistakes' => ''
			));

			if ($place['photo1'] != '')
				$command->insert('places_photo', array(
					'place_id' => $place['entry_id'],
					'filename' => $place['photo1'],
				));
			if ($place['photo2'] != '')
				$command->insert('places_photo', array(
					'place_id' => $place['entry_id'],
					'filename' => $place['photo2'],
				));
			if ($place['photo3'] != '')
				$command->insert('places_photo', array(
					'place_id' => $place['entry_id'],
					'filename' => $place['photo3'],
				));
			if ($place['photo4'] != '')
				$command->insert('places_photo', array(
					'place_id' => $place['entry_id'],
					'filename' => $place['photo4'],
				));
			if ($place['photo5'] != '')
				$command->insert('places_photo', array(
					'place_id' => $place['entry_id'],
					'filename' => $place['photo5'],
				));
			if ($place['photo6'] != '')
				$command->insert('places_photo', array(
					'place_id' => $place['entry_id'],
					'filename' => $place['photo6'],
				));
			if ($place['photo7'] != '')
				$command->insert('places_photo', array(
					'place_id' => $place['entry_id'],
					'filename' => $place['photo7'],
				));
			if ($place['photo8'] != '')
				$command->insert('places_photo', array(
					'place_id' => $place['entry_id'],
					'filename' => $place['photo8'],
				));
			if ($place['photo9'] != '')
				$command->insert('places_photo', array(
					'place_id' => $place['entry_id'],
					'filename' => $place['photo9'],
				));
			if ($place['photo10'] != '')
				$command->insert('places_photo', array(
					'place_id' => $place['entry_id'],
					'filename' => $place['photo10'],
				));

			$i++;
			echo "Place #{$i} imported\n";
		}
		echo "END importing places!!!\n";
	}

	public function actionArticles() {
		$q = "SELECT ecd.entry_id, author_id, title, url_title, ecd.field_id_20 AS pub_txt, ecd.field_id_21 AS pub_image, ecd.field_id_22 AS sub_header, ip_address, ect.status, year, month, day, entry_date FROM exp_channel_data AS ecd JOIN exp_channel_titles AS ect ON ecd.entry_id = ect.entry_id WHERE ecd.channel_id = 2 ORDER BY ecd.entry_id";
		$articles = Yii::app()->db2->createCommand($q)->queryAll();
		$i = 0;
		echo "Begin importing articles ...\n";
		$command = Yii::app()->db->createCommand();
		foreach ($articles as $article) {
			$command->insert('articles', array(
				'article_id' => $article['entry_id'],
				'title' => $article['title'],
				'url' => $article['url_title'],
				'pub_txt' => $article['pub_txt'],
				'pub_cover' => preg_replace("/{filedir_\d+}/", "", $article['pub_image']),
				'sub_header' => $article['sub_header'],
				'ip_address' => $article['ip_address'],
				'created_at' => $created_at = date('Y-d-m h:i:s', $article['entry_date']),
				'updated_at' => $created_at,
				'created_by' => $article['author_id'],
				'updated_by' => $article['author_id'],
				'status' => $article['status'] == "open" ? 1 : 0

			));
			$i++;
			echo "Article #{$i} imported\n";
		}
		echo "END importing articles!!!\n";
	}

	public function actionEvents() {
		$q = "SELECT ecd.entry_id, ecd.field_id_26 AS event_desc, ecd.field_id_27 AS event_entrance_male, ecd.field_id_28 AS event_entrance_female, ecd.field_id_30 AS event_place, ecd.field_id_37 AS event_img, ecd.field_id_38 AS event_alternative_place, ecd.field_id_39 AS event_alternative_place_details, author_id, ip_address, title, url_title, status, year, month, day FROM exp_channel_data AS ecd JOIN exp_channel_titles AS ect ON ecd.entry_id = ect.entry_id WHERE ecd.channel_id = 4 ORDER BY ecd.entry_id";
		$events = Yii::app()->db2->createCommand($q)->queryAll();
		$i = 0;
		echo "Begin importing events ...\n";
		$command = Yii::app()->db->createCommand();
		foreach ($events as $event) {
			$command->insert('events', array(
				'event_id' => $event['entry_id'],
				'author_id' => $event['author_id'],
				'title' => $event['title'],
				'url' => $event['url_title'],
				'event_desc' => $event['event_desc'],
				'event_place' => $event['event_place'],
				'event_alternative_place' => $event['event_alternative_place'],
				'event_alternative_place_details' => $event['event_alternative_place_details'],
				'event_entrance_male' => $event['event_entrance_male'],
				'event_entrance_female' => $event['event_entrance_female'],
				'event_img' => $event['event_img'],
				'ip_address' => $event['ip_address'],
				'event_date' => $event['year'] . "-" . $event['month'] . "-" . $event['day'],
				'status' => $event['status'] == "open" ? 1 : 0
			));
			$i++;
			echo "Event #{$i} imported\n";
		}
		echo "END importing events!!!\n";
	}

	public function actionAlbums() {
		$q = "SELECT ecd.entry_id, author_id, title, url_title, (SELECT rel_child_id FROM `exp_relationships` WHERE rel_id = ecd.field_id_45) AS place_id, ecd.field_id_46 AS album_cover, ecd.field_id_57 AS albumEvent, ip_address, ect.status, year, month, day FROM exp_channel_data AS ecd JOIN exp_channel_titles AS ect ON ecd.entry_id = ect.entry_id WHERE ecd.channel_id = 11 ORDER BY ecd.entry_id";
		$albums = Yii::app()->db2->createCommand($q)->queryAll();
		$i = 0;
		echo "Begin importing albums ...\n";
		$command = Yii::app()->db->createCommand();
		foreach ($albums as $album) {
			$album_cover = preg_replace("/{filedir_\d+}/", "", $album['album_cover']);
			$command->insert('albums', array(
				'album_id' => $album['entry_id'],
				'user_id' => $album['author_id'],
				'title' => $album['title'],
				'url' => $album['url_title'],
				'place_id' => $album['place_id'],
				'album_cover' => $album_cover,
				'albumEvent' => $album['albumEvent'],
				'ip_address' => $album['ip_address'],
				'album_date' => $album['year'] . "-" . $album['month'] . "-" . $album['day'],
				'status' => $album['status'] == "open" ? 1 : 0
			));
			//create directory for each album
			//mkdir("../uploads/albums/".$album['url_title'], 0644);

			$i++;
			echo "Album #{$i} imported\n";
		}
		echo "END importing albums!!!\n";
	}

	public function actionPhotos() {
		$q = "SELECT ecd.entry_id, (SELECT rel_child_id FROM `exp_relationships` WHERE rel_id = ecd.field_id_44) AS album_id, author_id, ecd.field_id_53 AS title, url_title, ecd.field_id_43 AS photoPath, ip_address, ect.status, year, month, day FROM exp_channel_data AS ecd JOIN exp_channel_titles AS ect ON ecd.entry_id = ect.entry_id WHERE ecd.channel_id = 6 ORDER BY ecd.entry_id";
		$photos = Yii::app()->db2->createCommand($q)->queryAll();
		$i = 0;
		echo "Begin importing photos ...\n";
		$command = Yii::app()->db->createCommand();
		foreach ($photos as $photo) {
			$photoPath = preg_replace("/{filedir_\d+}/", "", $photo['photoPath']);
			$command->insert('photos', array(
				'photo_id' => $photo['entry_id'],
				'album_id' => $photo['album_id'],
				'user_id' => $photo['author_id'],
				'title' => $photo['title'],
				'url' => $photo['url_title'],
				'filename' => $photoPath,
				'ip_address' => $photo['ip_address'],
				//'album_date' => $photo['year'] . "-" . $photo['month'] . "-" . $photo['day'],
				'status' => $photo['status'] == "open" ? 1 : 0
			));
			$i++;
			echo "Photo #{$i} imported\n";
		}
		echo "END importing photos!!!\n";
	}

	public function actionComments() {
		$q = "SELECT entry_id, channel_id, author_id AS user_id, status, ip_address, comment_date, comment FROM exp_comments WHERE channel_id in (1,2,4,6,11) ORDER BY comment_id ASC";
		$comments = Yii::app()->db2->createCommand($q)->queryAll();
		$i = 0;
		echo "Begin importing comments ...\n";
		$command = Yii::app()->db->createCommand();
		foreach ($comments as $comment) {
			switch ($comment["channel_id"]) {
				case 1:
					$type = "places";
					break;
				case 2:
					$type = "articles";
					break;
				case 4:
					$type = "events";
					break;
				case 6:
					$type = "photos";
					break;
				case 11:
					$type = "albums";
					break;
			}
			$command->insert('comments', array(
				'entry_id' => $comment['entry_id'],
				'language_id' => 1, //ru
				'type' => $type,
				'user_id' => $comment['user_id'],
				'comment' => $comment['comment'],
				'ip_address' => $comment['ip_address'],
				'comment_date' => $comment['comment_date'],
				'status' => $comment['status'] == "o" ? 1 : 0
			));
			$i++;
			echo "Comment #{$i} imported\n";
		}
		echo "END importing comments!!!\n";
	}
	
	public function actionRating() {
		$q = "SELECT * FROM exp_starsrating ORDER BY starsrating_id ASC";
		$ratings = Yii::app()->db2->createCommand($q)->queryAll();
		$i = 0;
		echo "Begin importing rating ...\n";
		$command = Yii::app()->db->createCommand();
		foreach ($ratings as $rating) {
			$command->insert('starsrating', array(
				'rating_id' => $rating['starsrating_id'],
				'entry_id' => $rating['entry_id'],
				'rating' => $rating['rating'],
				'user_id' => $rating['member_id'],
				'date' => $rating['date'],
				'ip_address' => $rating['ip_address'],
			));
			$i++;
			echo "Rating #{$i} imported\n";
		}
		echo "END importing rating!!!\n";
	}
}