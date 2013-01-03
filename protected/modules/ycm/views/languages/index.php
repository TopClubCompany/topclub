<?php 
$this->widget('bootstrap.widgets.TbGridView', array(
	'dataProvider' => LanguageModel::model()->search(),
	'columns' => array(
		'language_id',
		array(
			'name' => 'name',
			'type' => 'raw',
			'value' => 'CHtml::link($data->name, array("languages/edit", "language_id" => $data->language_id))'
		),
		'code',
		array(
			'name' => 'default',
			'value' => '$data->default == 1 ? Yii::t("common", "yes") : Yii::t("common", "no")',
			'cssClassExpression' => '$data->default == 1 ? "green" : "red"'
		),
		array(
			'name' => 'enabled',
			'value' => '$data->enabled == 1 ? Yii::t("common", "yes") : Yii::t("common", "no")',
			'cssClassExpression' => '$data->enabled == 1 ? "green" : "red"'
		),
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}',
			'updateButtonUrl' => 'CHtml::normalizeUrl(array("languages/edit", "language_id" => $data->language_id))',
			'deleteButtonUrl' => 'CHtml::normalizeUrl(array("languages/delete", "language_id" => $data->language_id))',
		),
	)
));
echo $this->module->getButtons();