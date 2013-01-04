<div class="control-group ">
	<label class="control-label">
		<?php echo $label ?>
	</label>
	<div class="controls">
		<?php $this->widget($this->module->name . '.extensions.redactor.ERedactorWidget', $options); ?>
	</div>
</div>