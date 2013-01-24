<div class="control-group form-horizontal">
	<label class="control-label">
		<?php echo Yii::t('YcmModule.places', 'Add photos') ?>
	</label>
	<div class="controls">

		<?php
		Yii::app()->clientScript->registerScript('xupload-places-images', "jQuery('#xupload-places-images').bind('fileuploadcompleted', function(e, data) {
		  jQuery('#places_photo').yiiGridView('update');
		  });
		  jQuery('#xupload-places-images').bind('fileuploaddestroyed', function(e, data) {
		  jQuery('#places_photo').yiiGridView('update');
		  });
		  ", CClientScript::POS_READY);
		$this->widget('xupload.XUpload', array(
			'url' => CHtml::normalizeUrl(array("places/upload", "place_id" => $model->place_id)),
			'model' => $photos,
			'id' => 'pizda',
			'attribute' => 'file',
			'multiple' => true,
			//'showForm' => false,
			'htmlOptions' => array(
				'class' => 'fileupload',
				'id' => 'xupload-places-images'
			),
		));
		?>

	</div>
</div>