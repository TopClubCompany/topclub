<?php

$this->module->createWidget(array(
	'formElementName' => $langCode . '[name]',
	'value' => $model->name,
	'attribute' => 'name',
	'model' => 'FiltersValuesDescModel'
));

$this->module->createWidget(array(
	'formElementName' => $langCode . '[description]',
	'value' => $model->description,
	'attribute' => 'description',
	'model' => FiltersValuesDescModel::model(),
	'type' => 'wysiwyg'
));