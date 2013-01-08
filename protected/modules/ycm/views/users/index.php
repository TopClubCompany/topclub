<?php 
$this->widget('bootstrap.widgets.TbGridView', array(
	'dataProvider' => UsersModel::model()->search(),
	'columns' => array(
		'user_id',
		'role',
        'username',
        'first_name',
        'last_name',
        'location',
		'email',
        'phone',
        'vk_id',
        'fb_id',
        'tw_id',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}',
			'updateButtonUrl' => 'CHtml::normalizeUrl(array("users/edit", "user_id" => $data->user_id))',
			'deleteButtonUrl' => 'CHtml::normalizeUrl(array("users/delete", "user_id" => $data->user_id))',
		),
	)
));
echo $this->module->getButtons();