<?php

class ImportCommand extends CConsoleCommand {

	public function actionUsers() {
		$q = "SELECT em.member_id, em.facebook_connect_user_id, em.vk_id, em.group_id,  em.password, em.email, em.location, em.bday_d, em.bday_m, em.bday_y, em.avatar_filename, em.photo_filename, em.ip_address, em.join_date, emd.m_field_id_1 AS twitter, emd.m_field_id_3 AS sex, emd.m_field_id_4 AS last_name, emd.m_field_id_6 AS about_tc, emd.m_field_id_7 AS status, emd.m_field_id_9 AS facebook, emd.m_field_id_10 AS city, emd.m_field_id_11 AS vkontakte, emd.m_field_id_12 AS phone, emd.m_field_id_15 AS first_name FROM  `exp_members` AS em JOIN exp_member_data AS emd ON em.member_id=emd.member_id WHERE rest_discounts != 1 ORDER BY em.member_id";
		$users = Yii::app()->db2->createCommand($q)->queryAll();
		$i = 0;
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
	}
	
	public function actionKitchens() {
		echo "Begin importing kitchens ...\n";
	}

}