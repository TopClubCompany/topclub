<?php
$this->module->createWidget(array(
	'formElementName' => $langCode . '[name]',
	'value' => $model->name,
	'attribute' => 'name',
	'model' => 'PlacesCategoriesDescModel'
));

$this->module->createWidget(array(
	'formElementName' => $langCode . '[description]',
	'value' => $model->description,
	'attribute' => 'description',
	'model' => PlacesCategoriesDescModel::model(),
	'type' => 'wysiwyg'
));
