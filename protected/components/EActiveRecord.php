<?php

/**
 * Description of EActiveRecord
 *
 * @author shults
 */
class EActiveRecord extends CActiveRecord {

	protected $_cacheKey;

	public function getCacheKey() {
		return $this->_cacheKey;
	}

	public function setCacheKey($cacheKey) {
		$this->_cacheKey = $cacheKey;
	}

	public function query($criteria, $all = false) {
		$this->beforeFind();
		$this->applyScopes($criteria);
		if (empty($criteria->with)) {
			if (!$all)
				$criteria->limit = 1;
			$command = $this->getCommandBuilder()->createFindCommand($this->getTableSchema(), $criteria);
			$records = $all ? $this->populateRecords($command->queryAll(), true, $criteria->index) : $this->populateRecord($command->queryRow());
			if (is_object($records) && $records instanceof EActiveRecord) {
				$records->setCacheKey($command->getCacheKey());
			} elseif (is_array($records[$key])) {
				foreach ($records as $key => $record) {
					if ($records[$key] instanceof EActiveRecord) {
						$records[$key]->setCacheKey($command->getCacheKey());
					}
				}
			}
			return $records;
		} else {
			
			$finder = new CActiveFinder($this, $criteria->with);
			return $finder->query($criteria, $all);
		}
	}

}