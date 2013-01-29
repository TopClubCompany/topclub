<?php $this->widget('chosen.EChosenWidget'); ?>

<div class="control-group">
	<label class="control-label" for="PlacesCategoriesModel_filters">
		<?php echo Yii::t('YcmModule.placesCategories', 'Filters') ?></label>
		<div class="controls">
<?php 
	echo CHtml::dropDownList("Filters", "filters", $filtersArray, array(
			'multiple' => 'multiple',
			'class' => 'span5 chzn-select',
			'data-placeholder' => Yii::t('YcmModule.placesCategories', 'Choose filters'),
			'options' => $selectedFilters,
		)
	); 
?>
		</div>
</div>