<?php
$this->module->createWidget(array(
	'formElementName' => $langCode . '[title]',
	'value' => $model->title,
	'attribute' => 'title',
	'model' => $model
));

$this->module->createWidget(array(
	'formElementName' => $langCode . '[street]',
	'value' => $model->street,
	'attribute' => 'street',
	'model' => $model
));

$this->module->createWidget(array(
	'formElementName' => $langCode . '[place_desc]',
	'value' => $model->place_desc,
	'attribute' => 'place_desc',
	'model' => $model,
	'type' => 'wysiwyg'
));

$this->module->createWidget(array(
	'formElementName' => $langCode . '[search_mistakes]',
	'value' => $model->search_mistakes,
	'attribute' => 'search_mistakes',
	'model' => $model,
));

$this->module->createWidget(array(
	'formElementName' => $langCode . '[place_orientir]',
	'value' => $model->place_orientir,
	'attribute' => 'place_orientir',
	'model' => $model,
	'type' => 'wysiwyg'
));