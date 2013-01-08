<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => get_class($model) . '-id-form',
	'type' => 'horizontal',
	'inlineErrors' => false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
$this->module->createActiveWidget($form, $FiltersValuesModel, 'url');
$this->module->createActiveWidget($form, $FiltersValuesModel, 'filter_id');
$this->endWidget();
echo $this->module->getButtons();