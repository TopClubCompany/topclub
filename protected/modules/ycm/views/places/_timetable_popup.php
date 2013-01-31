<div class="modal hide">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3><p>Edit timetable ...</p></h3>
  </div>
  <div class="modal-body">
    <p><table class="table table-striped table-bordered">
	<thead>
		<th>Day</th>
		<th>Time period</th>
	</thead>
	<tbody>
		<tr data-day="monday"><td><?php echo Yii::t('YcmModule.places', 'Monday'); ?></td><td name="edit_run">Running all day</td></tr>
		<tr data-day="tuesday"><td><?php echo Yii::t('YcmModule.places', 'Tuesday'); ?></td><td name="edit_run">Running all day</td></tr>
		<tr data-day="wednesday"><td><?php echo Yii::t('YcmModule.places', 'Wednesday'); ?></td><td name="edit_run">Running all day</td></tr>
		<tr data-day="thursday"><td><?php echo Yii::t('YcmModule.places', 'Thursday'); ?></td><td name="edit_run">Running all day</td></tr>
		<tr data-day="friday"><td><?php echo Yii::t('YcmModule.places', 'Friday'); ?></td><td name="edit_run">Running all day</td></tr>
		<tr data-day="saturday"><td><?php echo Yii::t('YcmModule.places', 'Saturday'); ?></td><td name="edit_run">Running all day</td></tr>
		<tr data-day="sunday"><td><?php echo Yii::t('YcmModule.places', 'Sunday'); ?></td><td name="edit_run">Running all day</td></tr>
	</tbody>
</table></p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn close">Close</a>
    <a href="#" class="btn btn-primary">Save changes</a>
  </div>
</div>