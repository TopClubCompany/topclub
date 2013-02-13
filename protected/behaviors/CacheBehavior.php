<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CacheBehaviour
 *
 * @author shults
 */
class CacheBehavior extends CActiveRecordBehavior {

	//private $_cacheKey;
	public $duration = 0;
	public $cache = 'cache';

	/* public function getCacheKey() {
	  return $this->_cacheKey;
	  } */

	public function beforeFind($event) {
		if (($this->owner instanceof EActiveRecord) === false) {
			throw new CException(get_class($this->owner) . ' class must be instance of EActiveRecord class');
		}
		$this->owner->cache($this->duration);
		parent::beforeFind($event);
	}

	public function afterDelete($event) {
		$cache = Yii::app()->getComponent($this->cache);
		if ($this->owner->getCacheKey() && $cache->get($this->owner->getCacheKey())) {
			$cache->delete($this->owner->getCacheKey());
		}
		parent::afterDelete($event);
	}

	public function afterSave($event) {
		$cache = Yii::app()->getComponent($this->cache);
		if ($this->owner->getCacheKey() && $cache->get($this->owner->getCacheKey())) {
			$cache->delete($this->owner->getCacheKey());
		}
		parent::afterSave($event);
	}

}