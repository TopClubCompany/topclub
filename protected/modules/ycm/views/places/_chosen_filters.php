<div id="category_filters">
	<div class="control-group">
		<label class="control-label" for="PlacesCategoriesModel_filters">
			<?php echo Yii::t('YcmModule.placesCategories', 'Filters') ?>
		</label>
		<div class="controls"></div>
	</div>
</div>
<?php 
$this->widget('chosen.EChosenWidget');

$url = CHtml::normalizeUrl(array('places/showFilters/place_id/'.$_GET["place_id"]));
Yii::app()->clientScript->registerScript('category-filters', 
		'
		url = "'.$url.'/category_id/";
		//when load	page - show filter(-s)
		category = jQuery("#PlacesModel_category_id").val();
		if(category){
			showFilters(url + category)
		}
		jQuery("#PlacesModel_category_id").change(function(data) {
			showFilters(url + $(this).val());
		});
		function showFilters(_url){
			$.post(_url, function (data){
				if($("#category_filters .control-group .controls").html(data)){
					$(".chzn-select").chosen();
				}
				
			});
		}
', CClientScript::POS_READY);