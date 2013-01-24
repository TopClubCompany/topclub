<div class="control-group ">
	<label class="control-label <?= ($model && $model->isAttributeRequired($attribute)) ? 'required' : null; ?> <?= ($model && $model->getError($attribute)) ? 'error' : null; ?>">
		<?php echo $label ?>
	</label>
	<div class="controls">
		<?php echo CHtml::textField($formElementName, $value, $htmlOptions); ?>
	</div>
</div>