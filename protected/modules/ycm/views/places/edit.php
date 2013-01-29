<?php

Yii::app()->clientScript->registerScript('category-filters', "jQuery('#PlacesModel_category_id').change(function(data) {
		  console.log($(this).val());
		  });
		  ", CClientScript::POS_READY);

$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => get_class($model) . '-id-form',
	'type' => 'horizontal',
	'inlineErrors' => false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
		));

echo $form->errorSummary($model);
foreach (LanguageModel::model()->enabled()->findAll() as $language) {
	echo $form->errorSummary($model->{$language->code}, static::t('Please fix the following errors (tab: {language})', array('{language}' => $language->name)));
}

$this->module->createActiveWidget($form, $model, 'category_id');
$this->module->createActiveWidget($form, $model, 'url');
$this->module->createActiveWidget($form, $model, 'status');
$this->module->createActiveWidget($form, $model, 'schedule');
$this->module->createActiveWidget($form, $model, 'street_number');
$this->module->createActiveWidget($form, $model, 'phones');
$this->module->createActiveWidget($form, $model, 'admin_phone');
$this->module->createActiveWidget($form, $model, 'website');
$this->module->createActiveWidget($form, $model, 'email');
$this->module->createActiveWidget($form, $model, 'cost');
$this->module->createActiveWidget($form, $model, 'lat');
$this->module->createActiveWidget($form, $model, 'lng');
$this->module->createActiveWidget($form, $model, 'order_discount');
$this->module->createActiveWidget($form, $model, 'order_discount_banket');
$this->module->createActiveWidget($form, $model, 'closed');

$this->widget('bootstrap.widgets.TbTabs', array(
	'type' => 'tabs',
	'tabs' => $tabs,
));

$this->renderPartial('_places_photos', array(
	'model' => $model,
));
echo $this->module->getButtons();

$this->endWidget();

$this->renderPartial('_image_uploader', array(
	'model' => $model,
	'photos' => $photos
));