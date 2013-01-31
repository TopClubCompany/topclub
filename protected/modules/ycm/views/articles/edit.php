<?php

//Create an instance of ColorBox
$colorbox = $this->widget('application.extensions.colorpowered.JColorBox');
 
//Call addInstance (chainable) from the widget generated.
$colorbox->addInstance('.colorbox', array('maxHeight'=>'100%', 'maxWidth'=>'100%'));
//show album cover
if($_GET["article_id"])
	echo CHtml::link(CHtml::image("/uploads/articles/".$model->article_id."/".$model->pub_cover, Yii::t('YcmModule.articles', 'Article cover'), array("width"=>150)), "/uploads/articles/".$model->article_id."/".$model->pub_cover."", array("class"=>"colorbox"));

$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => get_class($model) . '-id-form',
	'type' => 'horizontal',
	'inlineErrors' => false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
));

$this->module->createActiveWidget($form, $model, 'title');
if($_GET["article_id"])
	$this->module->createActiveWidget($form, $model, 'image');
$this->module->createActiveWidget($form, $model, 'sub_header');
$this->module->createActiveWidget($form, $model, 'pub_txt');
$this->module->createActiveWidget($form, $model, 'status');
echo $this->module->getButtons();
$this->endWidget();