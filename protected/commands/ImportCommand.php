<?php

class ImportCommand extends CConsoleCommand {

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
					'old_user_id' => $user['member_id'],
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
		$q = "SELECT ecd.entry_id, title, url_title, status, field_id_1 AS name, field_id_2 AS schedule, field_id_3 AS place_desc, field_id_4 AS street, field_id_5 AS street_number, field_id_6 AS place_orientir, field_id_8 AS phone, field_id_9 AS phone2, field_id_11 AS website, field_id_12 AS email, field_id_13 AS cost, field_id_14 AS photo1, field_id_15 AS photo2, field_id_16 AS photo3, field_id_17 AS photo4, field_id_18 AS photo5, field_id_25 AS search_mistakes, field_id_89 AS closed, field_id_96 AS photo6, field_id_97 AS photo7, field_id_98 AS photo8, field_id_99 AS photo9, field_id_100 AS photo10, field_id_108 AS admin_phone,field_id_109 AS order_discount, field_id_110 AS order_discount_banket, field_id_111 AS lat, field_id_112 AS lng FROM exp_channel_data AS ecd JOIN exp_channel_titles AS ect ON ecd.entry_id = ect.entry_id WHERE ecd.channel_id = 1 ORDER BY ecd.entry_id";
		$places = Yii::app()->db2->createCommand($q)->queryAll();
		$i = 0;
		echo "Begin importing places ...\n";
		$command = Yii::app()->db->createCommand();
		foreach ($places as $place) {
			$command->insert('places', array(
				'place_id' => $place['entry_id'],
				'title' => $place['title'],
				'url_title' => $place['url_title'],
				'status' => $place['status'],
				'name' => $place['name'],
				'schedule' => $place['schedule'],
				'place_desc' => $place['place_desc'],
				'street' => $place['street'],
				'street_number' => $place['street_number'],
				'place_orientir' => $place['place_orientir'],
				'phone' => $place['phone'],
				'phone2' => $place['phone2'],
				'admin_phone' => $place['admin_phone'],
				'website' => $place['website'],
				'email' => $place['email'],
				'cost' => $place['cost'],
				'lat' => $place['lat'],
				'lng' => $place['lng'],
				'order_discount' => $place['order_discount'],
				'order_discount_banket' => $place['order_discount_banket'],
				'photo1' => $place['photo1'],
				'photo2' => $place['photo2'],
				'photo3' => $place['photo3'],
				'photo4' => $place['photo4'],
				'photo5' => $place['photo5'],
				'photo6' => $place['photo6'],
				'photo7' => $place['photo7'],
				'photo8' => $place['photo8'],
				'photo9' => $place['photo9'],
				'photo10' => $place['photo10'],
				'search_mistakes' => $place['search_mistakes'],
				'closed' => $place['closed']
			));
			$i++;
			echo "Place #{$i} imported\n";
		}
		echo "END importing places!!!\n";
	}

}