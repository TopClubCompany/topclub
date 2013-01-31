<?php
$CommentsModel = CommentsModel::model();
$this->widget('bootstrap.widgets.TbGridView', array(
	'dataProvider' => $CommentsModel->search(),
	'filter' => $CommentsModel,
	'columns' => array(
		'comment_id',
		array(
			'name' => 'entry_id',
			'filter' => false,
			'value' => '$data->entry->title'
		),
		array(
			'name' => 'comment',
			'value' => '$data->comment',
		),
		array(
			'name' => 'type',
			'value' => '$data->getTypeChoice();',
			'filter' => false,
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
					) + $CommentsModel->statusChoices()
			)
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