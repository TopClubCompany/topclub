<?php 
$this->widget('bootstrap.widgets.TbGridView', array(
	'dataProvider' => PlacesModel::model()->search(),
	'columns' => array(
		'place_id',
		//'title',
		/*array(
			'name' => 'address',
			'type' => 'raw',
			'value' => '$data->street . " ". $data->street_number '
		),*/
		array(
			'name' => 'website',
			'type' => 'raw',
			'value' => 'CHtml::link($data->website, "http://".$data->website, array(target=>"_blank"));',
		),
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}',
			'updateButtonUrl' => 'CHtml::normalizeUrl(array("places/edit", "place_id" => $data->place_id))',
			'deleteButtonUrl' => 'CHtml::normalizeUrl(array("places/delete", "place_id" => $data->place_id))',
		),
	)
));
echo $this->module->getButtons();