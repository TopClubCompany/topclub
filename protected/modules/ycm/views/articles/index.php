<?php
//Create an instance of ColorBox
$colorbox = $this->widget('application.extensions.colorpowered.JColorBox');
 
//Call addInstance (chainable) from the widget generated.
$colorbox->addInstance('.colorbox', array('maxHeight'=>'100%', 'maxWidth'=>'100%'));

$this->widget('bootstrap.widgets.TbGridView', array(
	'dataProvider' => ArticlesModel::model()->search(),
	'columns' => array(
		array(
			'name' => 'pub_cover',
			'type' => 'html',
			'htmlOptions'=>	array(
				'width' => '100',
				'height' => '100'
			),
			'value' => 'CHtml::link(CHtml::image("/uploads/articles/".$data->article_id."/".$data->pub_cover."", Yii::t(\'YcmModule.albums\', \'Album cover\'), array("width"=>100)), "/uploads/albums/".$data->article_id."/".$data->pub_cover."", array("class"=>"colorbox"))'
		),
		'article_id',
		'title',
		'updated_at',
		array(
			'name' => 'status',
			'value' => '$data->getStatus();',
		),
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}',
			'updateButtonUrl' => 'CHtml::normalizeUrl(array("articles/edit", "article_id" => $data->article_id))',
			'deleteButtonUrl' => 'CHtml::normalizeUrl(array("articles/delete", "article_id" => $data->article_id))',
		),
	)
));
echo $this->module->getButtons();