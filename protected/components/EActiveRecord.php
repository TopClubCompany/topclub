<?php

/**
 * Description of EActiveRecord
 *
 * @author shults
 */
class EActiveRecord extends CActiveRecord {

	private $_keyMap;   //behavior property
	private $_keyDelimiter;  //behavior property
	private $_cacheComponentName = 'cache';  //behavior property
	private $_duration = 0;

	/**
	 * Yii cache component
	 * @var CCache 
	 */
	private $cache;

	/**
	 * Shows where the behaviour params defined
	 *
	 * @var boolean
	 */
	private $isBehaviorPropertiesDefined = false;

	public function getKeyMap() {
		return $this->_keyMap;
	}

	public function getKeyDelimiter() {
		return $this->_keyDelimiter;
	}

	public function getCacheComponentName() {
		return $this->_cacheComponentName;
	}

	public function getDuration() {
		return $this->_duration;
	}

	/**
	 * Initialize the behavior Params
	 * 
	 * @param mixed $behavior ECacheBehavior or Array
	 */
	public function initBehaviorProperties($behavior, $refresh = false) {
		if ($this->getIsBehaviorPropertiesDefined() == false || $refresh) {
			if ($behavior instanceof ECacheBehavior) {
				$this->_keyMap = $behavior->keyMap;
				$this->_keyDelimiter = $behavior->keyDelimiter;
				$this->_cacheComponentName = $behavior->cacheComponentName;
				$this->_duration = $behavior->duration;
			} elseif (is_array($behavior)) {
				$this->_keyMap = $behavior['keyMap'];
				$this->_keyDelimiter = $behavior['keyDelimiter'];
				$this->_cacheComponentName = $behavior['cacheComponentName'];
				$this->_duration = $behavior['duration'];
			} else {
				throw new CException('"Behavior" property must be instance of ECacheBehavior or an Array');
			}
			$this->initCache();
			$this->setIsBehaviorPropertiesDefined(true);
		}
	}

	private function initCache() {
		$this->cache = Yii::app()->getComponent($this->cacheComponentName);
	}

	/**
	 * If the behavior properties where defined it return true else false
	 * 
	 * @return boolean
	 */
	public function getIsBehaviorPropertiesDefined() {
		return $this->isBehaviorPropertiesDefined;
	}

	/**
	 * Sets the behavior _isBehaviorPropertiesDefined
	 * 
	 * @param boolean $value
	 */
	private function setIsBehaviorPropertiesDefined($value) {
		$this->isBehaviorPropertiesDefined = $value;
	}

	/**
	 * An array of cache params. It can be an array or null.
	 * <code>
	 *  array(
	 * 		:key1 => value1,
	 * 		:key2 => value2
	 * 	)
	 * </code>
	 * 
	 * @var mixed Array or null if not defined
	 */
	protected $cacheParams = array();

	/**
	 * Cache key of current find* request
	 * 
	 * @var string 
	 */
	protected $cacheKey;

	/**
	 * Method sets the params whitch where passet to method EActiveRecord::find*()
	 * 
	 * @param array $cacheParams array(key => value)
	 */
	protected function setCacheParams($cacheParams) {
		$this->cacheParams = $cacheParams;
	}

	/**
	 * Retrun params whithc where passed to EActiveRecord::find*().
	 * 
	 * @return mixed Return array or null
	 */
	protected function getCacheParams() {
		return $this->cacheParams;
	}

	protected function getCacheDuration() {
		foreach ($this->getKeyMap() as $item) {
			if ($item['keys'] == array_keys($this->getCacheParams()) && $item['duration']) {
				return $item['duration'];
			}
		}
		return $this->getDuration();
	}

	/**
	 * Returns string cacheKey if current key exists or null if does not exist
	 * 
	 * @return String if cacheKey exist. Null of not exists.
	 */
	protected function getCacheKey() {
		foreach ($this->getKeyMap() as $item) {
			if ($item['keys'] == array_keys($this->getCacheParams())) {
				return $this->cacheKey = get_class($this) . json_encode($this->getCacheParams());
			}
		}
		return null;
	}

	/**
	 * 
	 * @param type $pk
	 * @param string $condition
	 * @param array $params
	 * @return EActiveRecord
	 */
	public function findByPk($pk, $condition = '', $params = array()) {
		$this->beforeFind();
		if (($record = $this->findByPkInCache($pk, $condition = '', $params = array())) === null) {
			if (($record = parent::findByPk($pk, $condition, $params)) !== null && $this->getCacheKey()) {
				$this->cache->set($this->getCacheKey(), $record->getAttributes(), $this->getCacheDuration());
			}
		}
		if ($record instanceof EActiveRecord)
			$record->transmitBehaviorProperties($this);
		return $record;
	}

	public function transmitBehaviorProperties(EActiveRecord $record) {
		$this->initBehaviorProperties(array(
			'keyMap' => $record->getKeyMap(),
			'keyDelimiter' => $record->getKeyDelimiter(),
			'cacheComponentName' => $record->getCacheComponentName(),
			'duration' => $record->getDuration(),
		));
	}

	public function findByPkInCache($pk, $condition = '', $params = array()) {
		if (is_array($pk)) {
			$pkItems = array();
			foreach ($pk as $pkKey => $pkValue) {
				$pkItems[$pkKey] = $pkValue;
			}
			$this->setCacheParams(array_merge($pkItems, $params));
		} else {
			if ($this->primaryKey() === null)
				throw new CException('Primary key in ' . get_class($this) . ' is not defined. Define the primary key.');
			$this->setCacheParams(array_merge(array(
						':' . $this->primaryKey() => $pk
							), $params));
		}
		if ($this->getCacheKey() !== null && ($record = $this->cache->get($this->getCacheKey())) !== false) {
			return $this->populateRecord($record);
		}
		return null;
	}

	/**
	 * @see CActiveRecord::find()
	 */
	public function find($condition = '', $params = array()) {
		$this->beforeFind();
		if ($condition instanceof CDbCriteria || is_array($condition))
			return parent::find($condition, $params);
		if (($record = $this->findInCache($condition, $params)) === null) {
			if (($record = parent::find($condition, $params)) !== null && $this->getCacheKey() !== null) {
				$this->cache->set($this->getCacheKey(), $record->getAttributes(), $this->getDuration());
			}
		}
		if ($record instanceof EActiveRecord)
			$record->transmitBehaviorProperties($this);
		return $record;
	}

	/**
	 * 
	 * @param type $condition
	 * @param type $params
	 * @return null
	 */
	public function findInCache($condition = '', $params = array()) {
		$this->setCacheParams($params);
		if ($this->getCacheKey() !== null && ($record = $this->cache->get($this->getCacheKey())) !== false) {
			return $this->populateRecord($record);
		}
		return null;
	}

	public function findAll($condition = '', $params = array()) {
		$this->setCacheParams($params);
		return parent::findAll($condition, $params);
	}

	public function findAllByPk($pk, $condition = '', $params = array()) {
		return parent::findAllByPk($pk, $condition, $params);
	}

	public function getRelated($name, $refresh = false, $params = array()) {
		echo $name;
		return parent::getRelated($name, $refresh, $params);
	}

}