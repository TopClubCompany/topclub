<?php
$this->widget('bootstrap.widgets.TbGridView', array(
	'dataProvider' => PhotosModel::model()->search(),
	'columns' => array(
		'photo_id',
		'title',
		'url_title',
		'photoPath',
		'album_id',
		array(
			'name' => 'author_id',
			'value' => '$data->author->first_name . " " . $data->author->last_name'
		),
		
	)
));
echo $this->module->getButtons();
?>
