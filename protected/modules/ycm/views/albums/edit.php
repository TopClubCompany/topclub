<?php

$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => get_class($model) . '-id-form',
	'type' => 'horizontal',
	'inlineErrors' => false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
		));
$this->module->createActiveWidget($form, $model, 'name');
$this->module->createActiveWidget($form, $model, 'code');
$this->module->createActiveWidget($form, $model, 'enabled');
$this->module->createActiveWidget($form, $model, 'default');
echo $this->module->getButtons();
$this->endWidget();