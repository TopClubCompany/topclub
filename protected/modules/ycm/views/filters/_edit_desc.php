<?php
$this->module->createWidget(array(
	'formElementName' => 'desc_' . $langCode . '[name]',
	'value' => $model->name,
	'attribute' => 'name',
	'model' => 'FiltersDescModel'
));

$this->module->createWidget(array(
	'formElementName' => 'desc_' . $langCode . '[description]',
	'value' => $model->description,
	'attribute' => 'description',
	'model' => FiltersDescModel::model(),
	'type' => 'wysiwyg'
));
