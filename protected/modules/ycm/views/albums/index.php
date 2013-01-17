<?php
$this->widget('bootstrap.widgets.TbGridView', array(
	'dataProvider' => AlbumsModel::model()->search(),
	'columns' => array(
		array(
			'name' => 'album_cover',
			'type' => 'image',
			'htmlOptions'=>	array(
				'width' => '50',
				'height' => '50'
			),
			'value' => function ($data){
				return preg_replace("/{filedir_1}/","http://topclub.ua/images/sized/images/uploads/", $data->album_cover);
			}
		),
		'album_id',
		array(
			'name' => 'author_id',
			'value' => '$data->author->first_name . " " . $data->author->last_name'
		),
		array(
			'name' => 'title',
			'type' => 'raw',
			'value' => 'CHtml::link($data->title, array("albums/show", "album_id" => $data->album_id))'
		),
		array(
			'name' => 'place_id',
			'type' => 'raw',
			'value' => '$data->place_title->title'
		),
		'albumEvent',
		'album_date',
		'status',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}',
			'updateButtonUrl' => 'CHtml::normalizeUrl(array("albums/edit", "album_id" => $data->album_id))',
			'deleteButtonUrl' => 'CHtml::normalizeUrl(array("albums/delete", "album_id" => $data->album_id))',
		),
	)
));
echo $this->module->getButtons();