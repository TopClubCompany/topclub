<?php
$this->module->createWidget(array(
	'formElementName' => $langCode . '[name]',
	'value' => $model->name,
	'attribute' => 'name',
	'model' => 'PlacesDescModel'
));

$this->module->createWidget(array(
	'formElementName' => $langCode . '[street]',
	'value' => $model->street,
	'attribute' => 'street',
	'model' => 'PlacesDescModel'
));

$this->module->createWidget(array(
	'formElementName' => $langCode . '[place_desc]',
	'value' => $model->place_desc,
	'attribute' => 'place_desc',
	'model' => 'PlacesDescModel',
	'type' => 'wysiwyg'
));

$this->module->createWidget(array(
	'formElementName' => $langCode . '[search_mistakes]',
	'value' => $model->search_mistakes,
	'attribute' => 'search_mistakes',
	'model' => 'PlacesDescModel',
));

$this->module->createWidget(array(
	'formElementName' => $langCode . '[place_orientir]',
	'value' => $model->place_orientir,
	'attribute' => 'place_orientir',
	'model' => 'PlacesDescModel',
	'type' => 'wysiwyg'
));