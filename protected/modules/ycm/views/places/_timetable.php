<div id="place_timetable">
	<div class="control-group">
		<label class="control-label" for="PlacesTimetableModel_timetable">
			<?php echo Yii::t('YcmModule.places', 'Timetable') ?>
		</label>
		<div class="controls">
			<button class="btn btn-primary" data-toggle="modal" data-target="#show_popup_timetable"><?php echo Yii::t('YcmModule.places', 'Edit'); ?></button>
			<div id="timetable"></div>
		</div>
	</div>
</div>
<?php
$timetableScript = Yii::app()->
	assetManager->
	publish(
		Yii::app()->controller->module->basePath.'/assets/js/timetable.js',
		true,0,YII_DEBUG
	);
Yii::app()->clientScript->registerScriptFile($timetableScript, CClientScript::POS_END);