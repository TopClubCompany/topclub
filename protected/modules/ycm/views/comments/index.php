<?php

$this->widget('bootstrap.widgets.TbGridView', array(
	'dataProvider' => CommentsModel::model()->search(),
	'columns' => array(
		'comment_id',
		'place_id',
		'channel_id',
		'language_id',
		/*array(
			'name' => 'user_id',
			'value' => '$data->author->first_name . " " . $data->author->last_name'
		),*/
		'comment_date',
		'status',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}',
			'updateButtonUrl' => 'CHtml::normalizeUrl(array("comments/edit", "comment_id" => $data->comment_id))',
			'deleteButtonUrl' => 'CHtml::normalizeUrl(array("comments/delete", "comment_id" => $data->comment_id))',
		),
		/*array(
			'name' => 'album_cover',
			'type' => 'html',
			'htmlOptions'=>	array(
				'width' => '100',
				'height' => '100'
			),
			/*'value' => function ($data){
				return preg_replace("/{filedir_1}/","http://topclub.ua/images/sized/images/uploads/", $data->album_cover);
			}*/
			/*'value' => 'CHtml::link(CHtml::image("/uploads/albums/".$data->album_id."/".$data->album_cover."", Yii::t(\'YcmModule.albums\', \'Album cover\'), array("width"=>100)), "/uploads/albums/".$data->album_id."/".$data->album_cover."", array("class"=>"colorbox"))'
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
		),*/
	)
));
echo $this->module->getButtons();