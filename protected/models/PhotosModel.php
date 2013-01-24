<?php
class PhotosModel extends CActiveRecord {
	public $image;
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
			'photo_id' => Yii::t('YcmModule.photos', 'Photo id'),
			'album_id' => Yii::t('YcmModule.photos', 'Album id'),
			'user_id' => Yii::t('YcmModule.photos', 'User id'),
			'title' => Yii::t('YcmModule.photos', 'Title'),
			'url' => Yii::t('YcmModule.photos', 'Url'),
			'photoPath' => Yii::t('YcmModule.photos', 'Photo Path'),
			'album_date' => Yii::t('YcmModule.photos', 'Album date'),
			'status' => Yii::t('YcmModule.photos', 'Status')
		);
	}
	
	public function relations() {
		return array(
			'Photos' => array(self::HAS_ONE, 'AlbumsModel', array('album_id' => 'album_id')),
			'author' => array(self::HAS_ONE, 'UsersModel', array('user_id' => 'user_id')),
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