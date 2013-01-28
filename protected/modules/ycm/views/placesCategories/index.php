<?php
$lang = Yii::app()->getLanguage();
$this->widget('bootstrap.widgets.TbGridView', array(
	'dataProvider' => PlacesCategoriesModel::model()->search(),
	'columns' => array(
		'category_id',
		array(
			'name' => $lang . '.name',
			'type' => 'raw',
			'value' => '$data->' . $lang . '->name'
		),
		array(
			'name' => $lang . '.description',
		),
		'url',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}',
			'updateButtonUrl' => 'CHtml::normalizeUrl(array("PlacesCategories/edit", "category_id" => $data->category_id))',
			'deleteButtonUrl' => 'CHtml::normalizeUrl(array("PlacesCategories/delete", "category_id" => $data->category_id))',
		),
	)
));
echo $this->module->getButtons();