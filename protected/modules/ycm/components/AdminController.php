<?php

/**
 * AdminController is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class AdminController extends CController {

	/**
	 * @var string the default layout for the controller view. Defaults to 'ycm.views.layouts.main'.
	 */
	public $layout = 'ycm.views.layouts.main';

	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu = array();

	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs = array();

	/**
	 * 
	 */
	public $buttons = array();

	public function filters() {
		return array('accessControl');
	}

	public function getIndexButtons() {
		return array(
			array(
				'type' => 'primary',
				'label' => Yii::t('YcmModule.ycm', 'Create'),
				'url' => array(Yii::app()->controller->id . '/add'),
			)
		);
	}

	public function getFormButtons() {
		return array(
			array(
				'buttonType' => 'submit',
				'type' => 'primary',
				'label' => Yii::t('YcmModule.ycm', 'Save'),
				'htmlOptions' => array('name' => '_save', 'style' => 'margin-left:10px;')
			),
			array(
				'buttonType' => 'submit',
				'label' => Yii::t('YcmModule.ycm', 'Save and add another'),
				'htmlOptions' => array('name' => '_addanother', 'style' => 'margin-left:10px;')
			),
			array(
				'buttonType' => 'submit',
				'label' => Yii::t('YcmModule.ycm', 'Save and continue editing'),
				'htmlOptions' => array('name' => '_continue', 'style' => 'margin-left:10px;')
			),
		);
	}

}