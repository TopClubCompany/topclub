<?php

 $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
  'id' => get_class($model) . '-id-form',
  'type' => 'horizontal',
  'inlineErrors' => false,
  'htmlOptions' => array('enctype' => 'multipart/form-data'),
  ));
$this->widget('bootstrap.widgets.TbTabs', array(
	'type'=>'tabs',
	'tabs' => $tabs
));
  //$this->module->createActiveWidget($form, $model, 'title');
  $this->module->createActiveWidget($form, $model, 'url_title');
  $this->module->createActiveWidget($form, $model, 'status');
  //$this->module->createActiveWidget($form, $model, 'name');
  $this->module->createActiveWidget($form, $model, 'schedule');
  //$this->module->createActiveWidget($form, $model, 'place_desc');
  //$this->module->createActiveWidget($form, $model, 'street');
  $this->module->createActiveWidget($form, $model, 'street_number');
  $this->module->createActiveWidget($form, $model, 'phone');
  $this->module->createActiveWidget($form, $model, 'phone2');
  $this->module->createActiveWidget($form, $model, 'admin_phone');
  $this->module->createActiveWidget($form, $model, 'website');
  $this->module->createActiveWidget($form, $model, 'email');
  $this->module->createActiveWidget($form, $model, 'cost');
  $this->module->createActiveWidget($form, $model, 'lat');
  $this->module->createActiveWidget($form, $model, 'lng');
  $this->module->createActiveWidget($form, $model, 'order_discount');
  $this->module->createActiveWidget($form, $model, 'order_discount_banket');
  //$this->module->createActiveWidget($form, $model, 'search_mistakes');
  $this->module->createActiveWidget($form, $model, 'closed');
  $this->renderPartial('_places_photos', array(
  'model' => $model,
  ));
  echo $this->module->getButtons();
  $this->endWidget();
/**
 * Drag & Drop upload files
 */
$this->widget('xupload.XUpload', array(
	'url' => CHtml::normalizeUrl(array("places/upload", "place_id" => $model->place_id)),
	'model' => $photos,
	'attribute' => 'file',
	'multiple' => true,
	'autoUpload' => true,
	//'name' => 'file',
	'htmlOptions' => array(
		'class' => 'fileupload',
	),
));
/**
 * also add specified dropzone: html, css, js
 * $('.fileupload').each(function () {
  $(this).fileupload({
  dropZone: $(this)
  });
  });
 */?>