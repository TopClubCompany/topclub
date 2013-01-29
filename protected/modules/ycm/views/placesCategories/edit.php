<?php

$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => get_class($model) . '-id-form',
	'type' => 'horizontal',
	'inlineErrors' => false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
));

$this->module->createActiveWidget($form, $PlacesCategoriesModel, 'url');

$selectedValues = array();
$categories = PlacesCategoriesToFiltersModel::model()->findAll('category_id=:category_id', array(':category_id' => $PlacesCategoriesModel->category_id));

foreach($categories as $filters){
	$selectedValues[$filters->filter_id] = array('selected' => 'selected');
}


$language_id = LanguageModel::model()->find('code=:code', array(':code' => Yii::app()->language))->language_id;
$multipleChosenArray = CHtml::listData(
		FiltersDescModel::model()->findAll('language_id=:language_id', array(':language_id' => $language_id)),
		"filter_id", 
		'name'
);
//filters
$this->widget('chosen.EChosenWidget');

echo '<div class="control-group">
	<label class="control-label" for="PlacesCategoriesModel_filters">'.Yii::t('YcmModule.placesCategories', 'Filters').'</label>
		<div class="controls">';
echo CHtml::dropDownList("Filters", "filters", $multipleChosenArray, array(
		'multiple' => 'multiple',
		'class' => 'span5 chzn-select',
		'options' => $selectedValues,
	)
);
echo '</div></div>';


$this->widget('bootstrap.widgets.TbTabs', array(
	'type' => 'tabs',
	'tabs' => $tabs
));



echo $this->module->getButtons();
$this->endWidget();