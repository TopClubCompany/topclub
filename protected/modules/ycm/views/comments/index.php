<?php
$ajaxUrl = CHtml::normalizeUrl(array('Comments/index'));
$addUrl = CHtml::normalizeUrl(array('Comments/add'));
$this->widget('bootstrap.widgets.TbGridView', array(
	'dataProvider' => $CommentsModel->search(),
	'filter' => $CommentsModel,
	'ajaxUrl' => $ajaxUrl,
	'beforeAjaxUpdate' => 'js: function(id,options){
		var url = decodeURIComponent(options.url);
		var indexUrl = \'' . $ajaxUrl . '\';
		var addUrl = \'' . $addUrl . '\';
		if (matches = url.match(/CommentsModel\[comment_id\]=([^&]+)/)) {
			var comment_id = matches[1];
			window.history.pushState(null, null, indexUrl  + \'/CommentsModel[comment_id]/\' + comment_id);
		} else if (matches = url.match(/CommentsModel\[type\]=([^&]+)/)) { 
			var type = matches[1];
			window.history.pushState(null, null, indexUrl  + \'/CommentsModel[type]/\' + type);
		} else if (matches = url.match(/CommentsModel\[language_id\]=([^&]+)/)) { 
			var language_id = matches[1];
			window.history.pushState(null, null, indexUrl  + \'/CommentsModel[language_id]/\' + language_id);
		} else if (matches = url.match(/CommentsModel\[status\]=([^&]+)/)) { 
			var status = matches[1];
			window.history.pushState(null, null, indexUrl  + \'/CommentsModel[status]/\' + status);
		} else {
			window.history.pushState(null, null, indexUrl);
		}
	}',
	'columns' => array(
		'comment_id',
		array(
			'name' => 'entry_id',
			'filter' => false,
			'value' => '$data->entry->title'
		),
		array(
			'name' => 'type',
			'value' => '$data->getTypeChoice();',
			'filter' => CHtml::activeDropDownList(
					$CommentsModel, 
					'type', 
					array_merge(array(	
						"" => Yii::t('YcmModule.comments', 'Select Type')
						), $CommentsModel->typeChoices()))
		),
		array(
			'name' => 'language_id',
			'value' => '$data->language->name',
			'filter' => CHtml::activeDropDownList(
					$CommentsModel, 
					'language_id', 
					array(	
						"" => Yii::t('YcmModule.comments', 'Select Language')
						) + $CommentsModel->language_idChoices())
		),
		array(
			'name' => 'user_id',
			'value' => '$data->user->first_name . " " . $data->user->last_name',
			'filter' => false
		),
		array(
			'name' => 'comment_date',
			'value' => function($data){
				$date = date('Y', $data->comment_date)."-".date('m', $data->comment_date)."-".date('d', $data->comment_date);
				return $date;
			},
			'filter' => false
		),
		array(
			'name' => 'status',
			'value' => '$data->getStatus();',
			'filter' => CHtml::activeDropDownList(
					$CommentsModel, 
					'status', 
					array(	
						"" => Yii::t('YcmModule.comments', 'Select Status')
						) + $CommentsModel->statusChoices())
		),
		array(
			'class' => 'CButtonColumn',
			'template' => '{update}{delete}',
			'updateButtonUrl' => 'CHtml::normalizeUrl(array("comments/edit", "comment_id" => $data->comment_id))',
			'deleteButtonUrl' => 'CHtml::normalizeUrl(array("comments/delete", "comment_id" => $data->comment_id))',
		),
	)
));
echo $this->module->getButtons();