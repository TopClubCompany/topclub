<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => get_class($model) . '-id-form',
	'type' => 'horizontal',
	'inlineErrors' => false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
		));
$this->module->createActiveWidget($form, $model, 'role');
$this->module->createActiveWidget($form, $model, 'username');
$this->module->createActiveWidget($form, $model, 'first_name');
$this->module->createActiveWidget($form, $model, 'last_name');
$this->module->createActiveWidget($form, $model, 'password');
$this->module->createActiveWidget($form, $model, 'password_repeat');
$this->module->createActiveWidget($form, $model, 'location');
$this->module->createActiveWidget($form, $model, 'phone');
$this->module->createActiveWidget($form, $model, 'vk_id');
$this->module->createActiveWidget($form, $model, 'fb_id');
$this->module->createActiveWidget($form, $model, 'tw_id');
echo $this->module->getButtons();
$this->endWidget();
