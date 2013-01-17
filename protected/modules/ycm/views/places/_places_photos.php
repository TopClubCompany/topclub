<div class="control-group ">
	<label class="control-label"><?php Yii::t('YcmModule.places', 'Places photos') ?></label>
	<div class="controls">
		<?php
		$this->widget('bootstrap.widgets.TbGridView', array(
			'dataProvider' => new CActiveDataProvider(PlacesPhotoModel::model(), array(	'data' => $model->places_photo,), true),
			'id' => 'places_photo',
			'summaryText' => '',
			'columns' => array(
				array(
					'type' => 'image',
					'htmlOptions'=>	array(
						'width' => '50',
						'height' => '50'
					),
					'value' => function ($data){
						$photo = preg_replace("/{filedir_1}/","http://topclub.ua/images/sized/images/uploads/", $data->filename);
						$photo = preg_replace("/\.jpg/","-120x84.jpg", $photo);
						$photo = preg_replace("/\.png/","-120x84.png", $photo);
						return $photo;

					}
				),
				'filename',
				array(
					'class' => 'CButtonColumn',
					'template' => '{delete}',
					'deleteButtonUrl' => 'CHtml::normalizeUrl(array("places/deleteImage", "photo_id" => $data->photo_id))',
				),
			)
		));
	
	?>
	</div>
</div>