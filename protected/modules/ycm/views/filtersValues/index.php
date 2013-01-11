<?php 
$lang = Yii::app()->getLanguage();
$ajaxUrl = CHtml::normalizeUrl(array('FiltersValues/index'));
$addUrl = CHtml::normalizeUrl(array('FiltersValues/add'));
$this->widget('bootstrap.widgets.TbGridView', array(
	'dataProvider' => $FiltersValuesModel->search(),
	'filter' => $FiltersValuesModel,
	'ajaxUrl' => $ajaxUrl,
	'beforeAjaxUpdate' => 'js: function(id,options){
		var url = decodeURIComponent(options.url);
		var indexUrl = \'' . $ajaxUrl . '\';
		var addUrl = \'' . $addUrl . '\';
		if (matches = url.match(/FiltersValuesModel\[filter_id\]=([^&]+)/)) {
			var filter_id = matches[1];
			window.history.pushState(null, null, indexUrl  + \'/FiltersValuesModel[filter_id]/\' + filter_id);
			$("#create-button").attr("href", addUrl + \'/FiltersValuesModel[filter_id]/\' + filter_id);
		} else {
			window.history.pushState(null, null, indexUrl);
			$("#create-button").attr("href", addUrl);
		}
	}',
	'columns' => array(
		array(
			'name' => 'value_id',
			'filter' => false
		),
		array(
			'name' => $lang . '.name',
		),
		array(
			'name' => 'filter_id',
			'filter' => CHtml::activeDropDownList($FiltersValuesModel, 'filter_id',  array('' => Yii::t('YcmModule.filters', '-=Select Filter=-')) + CHtml::listData(FiltersModel::model()->findAll(), 'filter_id', $lang . '.name')),
			'value' => '$data->filter->' . $lang . '->name'
		),
	)
));
echo $this->module->getButtons();