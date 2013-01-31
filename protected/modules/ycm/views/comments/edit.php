<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => get_class($model) . '-id-form',
	'type' => 'horizontal',
	'inlineErrors' => false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
));

//$this->module->createActiveWidget($form, $model, 'type');
$this->module->createActiveWidget($form, $model, 'language_id');
$this->module->createActiveWidget($form, $model, 'comment');
$this->module->createActiveWidget($form, $model, 'status');

echo $this->module->getButtons();
$this->endWidget();