<?php

/**
 * Description of CacheBehaviour
 *
 * @author shults
 */
class ECacheBehavior extends CActiveRecordBehavior {

	/**
	 * This property describes keys whitch will be used if caching. 
	 * <code>
	 *	//First example
	 *	//class Artciles
	 *	'keyMap' => array(
	 *		array(
	 *			'keys' => array(':article_id'),
	 *			'duration' => 1800
	 *		)
	 *	)
	 *	....
	 *  //Second example
	 *	//class ArtcileTranslate
	 *	'keyMap' => array(
	 *		array(
	 *			'keys' => array(':article_id', ':language_id'),
	 *			'duration' => 1800
	 *		),
	 *	)
	 *	...
	 *	//Third example
	 *	//class Languages
	 *	'keyMap' => array(
	 *		array(
	 *			'keys' => array(':language_id'),
	 *			'duration' => 3600 * 24 * 7
	 *		),
	 *		array(
	 *			'keys' => array(':code'), // code key may be one of: en, ru, bg, ua, pl ...
	 *			'duration' => 3600 * 24 * 7
	 *		)
	 *	)
	 * </code>
	 *
	 * @var array 
	 */
	public $keyMap;
	public $keyDelimiter = '|';
	public $cacheComponentName = 'cache';
	public $duration = 0;

	public function beforeFind($event) {
		Yii::trace('Behavior beforeFind method start. Behavior owner => ' . get_class($this->owner), 'application.behavior.ECacheBehavior');
		if (($this->owner instanceof EActiveRecord) === false)
			throw new CException('Class ' . get_class($this->owner) . ' must be inherited from EActiveRecord class.');
		if (!is_array($this->keyMap))
			throw new CException('The property "keyMap" of behavior ' . get_class($this) . ' is not defined. Define it please.');
		$this->owner->initBehaviorProperties($this);
		$this->enabled = false;
		parent::beforeFind($event);
	}

}