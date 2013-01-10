<?php 
$this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'dataProvider' => ProfileModel::model()->search(),
	'columns' => array(
		'user_id',
		'role',
        'username',
        'first_name',
        'last_name',
       array(
			'class'=>'CButtonColumn',
			'template' => '{update}',
			'updateButtonUrl' => 'CHtml::normalizeUrl(array("profile/edit", "user_id" => $data->user_id))'
		),
	)
));
echo $this->module->getButtons();