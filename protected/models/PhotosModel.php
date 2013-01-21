<?php
class PhotosModel extends CActiveRecord {
	
	/**
	 * 
	 * @param string $className
	 * @return PhotosModel
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
	
	public function tableName() {
		return 'photos';
	}
	
	public function primaryKey() {
		return 'photo_id';
	}
	
	public function attributeLabels() {
		return array(
			'photo_id' => Yii::t('YcmModule.photos', 'photo_id'),
			'album_id' => Yii::t('YcmModule.photos', 'album_id'),
			'author_id' => Yii::t('YcmModule.photos', 'author_id'),
			'title' => Yii::t('YcmModule.photos', 'title'),
			'url_title' => Yii::t('YcmModule.photos', 'url_title'),
			'photoPath' => Yii::t('YcmModule.photos', 'photoPath'),
			'album_date' => Yii::t('YcmModule.photos', 'album_date'),
			'status' => Yii::t('YcmModule.photos', 'status')
		);
	}
	
	public function relations() {
		return array(
			'Photos' => array(self::HAS_ONE, 'AlbumsModel', array('album_id' => 'album_id')),
			'author' => array(self::HAS_ONE, 'UsersModel', array('user_id' => 'author_id')),
		);
	}
	
	public function search() {
		$criteria = new CDbCriteria();
		
		if ($_GET['album_id']) {
			if ($album_id = (int) $_GET['album_id'] ? : null) {
				$this->album_id = $album_id;
				$criteria->addCondition('album_id=:album_id');
				$criteria->params = array_merge($criteria->params, array(
					':album_id' => $album_id
				));
			}
		}
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria
		));
	}
}