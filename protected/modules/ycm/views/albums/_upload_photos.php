<?php
if($count_photos <= 0)
	echo "<h3>Нет фоток</h3>";
else {
	//Create an instance of ColorBox
	$colorbox = $this->widget('application.extensions.colorpowered.JColorBox');
 
	//Call addInstance (chainable) from the widget generated.
	$colorbox->addInstance('.colorbox', array('maxHeight'=>'100%', 'maxWidth'=>'100%'));
   	
	$this->widget('bootstrap.widgets.TbGridView', array(
		'dataProvider' => PhotosModel::model()->search(),
		'columns' => array(
			array(
				'name' => 'image',
				'type' => 'html',
				'htmlOptions'=>	array(
					'width' => '100',
					'height' => '100',
				),
				//'value' => '"/uploads/albums/".$data->album_id."/".$data->photoPath.""'
				'value'=> 'CHtml::link(CHtml::image("/uploads/albums/".$data->album_id."/".$data->photoPath."", Yii::t(\'YcmModule.albums\', \'Album cover\'), array("width"=>30)), "/uploads/albums/".$data->album_id."/".$data->photoPath."", array("class"=>"colorbox"))'
			),
			'photo_id',
			'title',
			'url_title',
			'photoPath',
			array(
				'class'=>'CButtonColumn',
				'template' => '{delete}',
				'deleteButtonUrl' => 'CHtml::normalizeUrl(array("albums/deleteImage", "photo_id" => $data->photo_id))',
			),
		)
	));
}
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => get_class($model) . '-id-form',
	'type' => 'horizontal',
	'inlineErrors' => false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
echo $this->module->getButtons();
$this->endWidget();
/**
 * Drag & Drop upload files
 */
$this->widget('xupload.XUpload', array(
	'url' => CHtml::normalizeUrl(array("albums/upload", "album_id" => $_GET["album_id"], "author_id" => $author_id)),
	'model' => $upload_photos,
	'attribute' => 'file',
	'multiple' => true,
	'autoUpload' => true,
	'htmlOptions' => array(
		'class' => 'fileupload',
	),
));
?>