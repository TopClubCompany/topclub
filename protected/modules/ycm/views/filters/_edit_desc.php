<?php
$this->module->createWidget(array(
	'formElementName' => $langCode . '[name]',
	'value' => $model->name,
	'attribute' => 'name',
	'model' => 'FiltersDescModel'
));

$this->module->createWidget(array(
	'formElementName' => $langCode . '[description]',
	'value' => $model->description,
	'attribute' => 'description',
	'model' => FiltersDescModel::model(),
	'type' => 'wysiwyg'
));
