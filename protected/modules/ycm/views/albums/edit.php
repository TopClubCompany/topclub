<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => get_class($model) . '-id-form',
	'type' => 'horizontal',
	'inlineErrors' => false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
		));
$this->module->createActiveWidget($form, $model, 'author_id');
$this->module->createActiveWidget($form, $model, 'title');
$this->module->createActiveWidget($form, $model, 'url_title');
$this->module->createActiveWidget($form, $model, 'place_id');
$this->module->createActiveWidget($form, $model, 'album_cover');
$this->module->createActiveWidget($form, $model, 'albumEvent');
$this->module->createActiveWidget($form, $model, 'album_date');
$this->module->createActiveWidget($form, $model, 'status');
echo $this->module->getButtons();
$this->endWidget();