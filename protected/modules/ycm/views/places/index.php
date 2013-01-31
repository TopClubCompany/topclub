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
			'template' => '{view}{update}{delete}',
			'viewButtonUrl' => 'CHtml::normalizeUrl(array("places/showComments", "place_id" => $data->place_id))',
			'viewButtonLabel' => Yii::t('YcmModule.places', 'Look comments'),
			'updateButtonUrl' => 'CHtml::normalizeUrl(array("places/edit", "place_id" => $data->place_id))',
			'deleteButtonUrl' => 'CHtml::normalizeUrl(array("places/delete", "place_id" => $data->place_id))',
		),
	)
));
echo $this->module->getButtons();