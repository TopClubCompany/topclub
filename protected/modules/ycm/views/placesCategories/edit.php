<?php

$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => get_class($model) . '-id-form',
	'type' => 'horizontal',
	'inlineErrors' => false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
));

$this->module->createActiveWidget($form, $PlacesCategoriesModel, 'url');

//filters
$this->renderPartial("_chosen_filters", array(
	'filtersArray' => $filtersArray,
	'selectedFilters' => $selectedFilters,
));
//tabs
$this->widget('bootstrap.widgets.TbTabs', array(
	'type' => 'tabs',
	'tabs' => $tabs
));



echo $this->module->getButtons();
$this->endWidget();