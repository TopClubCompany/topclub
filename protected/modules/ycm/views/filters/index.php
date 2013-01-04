<?php
$lang = Yii::app()->getLanguage();
$this->widget('bootstrap.widgets.TbGridView', array(
	'dataProvider' => FiltersModel::model()->search(),
	'columns' => array(
		'filter_id',
		array(
			'name' => 'desc_' . $lang . '.name',
			'type' => 'raw',
			'value' => 'CHtml::link($data->desc_' . $lang . '->name, array("Filters/edit", "filter_id" => $data->filter_id))'
		),
		array(
			'name' => 'desc_' . $lang . '.description',
		),
		'url',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}',
			'updateButtonUrl' => 'CHtml::normalizeUrl(array("Filters/edit", "filter_id" => $data->filter_id))',
			'deleteButtonUrl' => 'CHtml::normalizeUrl(array("Filters/delete", "filter_id" => $data->filter_id))',
		),
	)
));
echo $this->module->getButtons();