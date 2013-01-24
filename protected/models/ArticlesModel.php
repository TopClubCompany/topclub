<?php

class ArticlesModel extends CActiveRecord {
	/**
	 * 
	 * @param String $className
	 * @return Articles
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
	
	public function tableName() {
		return 'articles';
	}

	public function primaryKey() {
		return 'article_id';
	}

	public function search() {
		return new CActiveDataProvider($this);
	}

}
