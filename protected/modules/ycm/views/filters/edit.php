<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => get_class($model) . '-id-form',
	'type' => 'horizontal',
	'inlineErrors' => false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
$this->module->createActiveWidget($form, $FiltersModel, 'url');
$this->widget('bootstrap.widgets.TbTabs', array(
	'type'=>'tabs',
	'tabs' => $tabs
));
echo $this->module->getButtons();
$this->endWidget();