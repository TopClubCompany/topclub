<?php
if($count_photos <= 0)
	echo "<h3>Нет фоток</h3>";
else {
	$this->widget('bootstrap.widgets.TbGridView', array(
		'dataProvider' => PhotosModel::model()->search(),
		'columns' => array(
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
	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id' => get_class($model) . '-id-form',
		'type' => 'horizontal',
		'inlineErrors' => false,
		'htmlOptions' => array('enctype' => 'multipart/form-data'),
	));
	echo $this->module->getButtons();
	$this->endWidget();
}

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