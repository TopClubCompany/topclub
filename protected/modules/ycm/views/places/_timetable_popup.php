<div class="modal hide" style="width: 300px">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3><p><?php echo Yii::t('YcmModule.places', 'Edit timetable'); ?> ...</p></h3>
  </div>
  <div class="modal-body">
    <p><table class="table table-striped table-bordered" data-json-update='<? if($timetable) echo true; else echo false; ?>'>
	<thead>
		<th><?php echo Yii::t('YcmModule.places', 'Day'); ?></th>
		<th><?php echo Yii::t('YcmModule.places', 'Schedule'); ?></th>
	</thead>
	<tbody>
		<?php
		$weekArr = array(
			'monday' => 'Monday',
			'tuesday' => 'Tuesday',
			'wednesday' => 'Wednesday',
			'thursday' => 'Thursday',
			'friday' => 'Friday',
			'saturday' => 'Saturday',
			'sunday' => 'Sunday'
		);
		foreach ($weekArr as $key => $value) {
			echo '<tr data-day="'.$key.'">
				<td>'.Yii::t('YcmModule.places', $value).'</td>
				<td name="edit_run">';
				if(!$timetable[$key]['day_and_night']){
					$time_to = $timetable[$key]["time_to"] == "Last client" ? "Last client" : preg_replace("/:00$/", "", $timetable[$key]["time_to"]);
					echo preg_replace("/:00$/", "", $timetable[$key]["time_from"])." - ".$time_to;
				} else { 
					echo "24/7";
				}
			echo '</td></tr>';
		}
		?>
	</tbody>
</table></p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn close">Close</a>
    <a href="#" class="btn btn-primary" id="save_changes">Save changes</a>
  </div>
</div>