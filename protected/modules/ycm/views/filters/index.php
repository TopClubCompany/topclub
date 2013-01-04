<?php
$lang = Yii::app()->getLanguage();
$this->widget('bootstrap.widgets.TbGridView', array(
	'dataProvider' => FiltersModel::model()->search(),
	'columns' => array(
		'filter_id',
		array(
			'name' => 'desc_' . $lang . '.name',
			'type' => 'raw',
			'value' => 'CHtml::link($data->desc_' . $lang . '->name, array("FiltersValues/index", "filter_id" => $data->filter_id))'
		),
		array(
			'name' => 'desc_' . $lang . '.description',
		),
		'url',
		array(
			'class'=>'CButtonColumn',
			'template' => '{view}{update}{delete}',
			'viewButtonUrl' => 'CHtml::normalizeUrl(array("FiltersValues/index", "filter_id" => $data->filter_id))',
			'updateButtonUrl' => 'CHtml::normalizeUrl(array("Filters/edit", "filter_id" => $data->filter_id))',
			'deleteButtonUrl' => 'CHtml::normalizeUrl(array("Filters/delete", "filter_id" => $data->filter_id))',
		),
	)
));
echo $this->module->getButtons();