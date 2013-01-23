<?php
//Create an instance of ColorBox
$colorbox = $this->widget('application.extensions.colorpowered.JColorBox');
 
//Call addInstance (chainable) from the widget generated.
$colorbox->addInstance('.colorbox', array('maxHeight'=>'100%', 'maxWidth'=>'100%'));
//show album cover
echo CHtml::link(CHtml::image("/uploads/albums/".$model->album_id."/".$model->album_cover."", "image", array("width"=>150)), "/uploads/albums/".$model->album_id."/".$model->album_cover."", array("class"=>"colorbox"));

$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => get_class($model) . '-id-form',
	'type' => 'horizontal',
	'inlineErrors' => false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
$this->module->createActiveWidget($form, $model, 'title');
//$this->module->createActiveWidget($form, $model, 'url_title');
$this->module->createActiveWidget($form, $model, 'place_id');
$this->module->createActiveWidget($form, $model, 'image');
$this->module->createActiveWidget($form, $model, 'albumEvent');
$this->module->createActiveWidget($form, $model, 'album_date');
$this->module->createActiveWidget($form, $model, 'status');

echo "<a href='".CHtml::normalizeUrl(array(
	"albums/show", "album_id" => $_GET["album_id"]
	))."'>".Yii::t('YcmModule.albums', 'Add photos')."</a>";
echo $this->module->getButtons();
$this->endWidget();