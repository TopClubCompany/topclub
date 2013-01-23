<?php 
$lang = Yii::app()->getLanguage();
$this->widget('bootstrap.widgets.TbGridView', array(
	'dataProvider' => PlacesModel::model()->search(),
	'columns' => array(
		'place_id',
		array(
			'name' => $lang . '.title',
		),
		array(
			'name' => 'website',
			'type' => 'raw',
			'value' => '$data->website ? CHtml::link($data->website, "http://".$data->website, array(target=>"_blank")) : Yii::t("YcmModule.places", "Without site");',
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