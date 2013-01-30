<div id="place_map">
	<div class="control-group">
		<label class="control-label" for="PlacesCategoriesModel_filters">
			<?php echo Yii::t('YcmModule.places', 'Map') ?>
		</label>
		<div class="controls">
			<div id="map_canvas" style="width: 400px; height: 300px;">

			</div>
			<div id="infoPanel">
				<b>Marker status:</b>
				<div id="markerStatus"><i>Click and drag the marker.</i></div>
				<b>Current position:</b>
				<div id="info"></div>
				<b>Closest matching address:</b>
				<div id="address"></div>
			</div>
		</div>
	</div>
</div>
<?php
/*
 * draggable markers
 * http://code.google.com/p/gmaps-samples-v3/source/browse/trunk/draggable-markers/draggable-markers.html?r=49
 */
Yii::app()->clientScript->registerScriptFile('http://maps.google.com/maps/api/js?sensor=true', CClientScript::POS_END);
Yii::app()->clientScript->registerScript('place_map', '	
	jQuery(document).ready(function (){
		var geocoder = new google.maps.Geocoder();
		function geocodePosition(pos) {
		  geocoder.geocode({
			latLng: pos
		  }, function(responses) {
			if (responses && responses.length > 0) {
			  updateMarkerAddress(responses[0].formatted_address);
			} else {
			  updateMarkerAddress("Cannot determine address at this location.");
			}
		  });
		}

		function updateMarkerStatus(str) {
		  document.getElementById("markerStatus").innerHTML = str;
		}

		function updateMarkerPosition(latLng) {
		  document.getElementById("info").innerHTML = [
			latLng.lat(),
			latLng.lng()
		  ].join(", ");
		}

		function updateMarkerAddress(str) {
		  document.getElementById("address").innerHTML = str;
		}		
		
		var map;
		function initialize(){
			lat = $("#PlacesModel_lat").val()
			lng = $("#PlacesModel_lng").val()
			var latLng = new google.maps.LatLng(lat, lng); //By default Kyiv is loaded
			//Инициализируем карту.
			var mapOptions = {
				zoom: 13, //Уровень зума
				center: latLng, //Координаты центра карты
				mapTypeId: google.maps.MapTypeId.ROADMAP  //Тип карты
			}
			map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
			
			var marker = new google.maps.Marker({
				map: map,
				position: latLng,
				animation: google.maps.Animation.DROP,
				draggable: true
			});
			
			// Update current position info.
			updateMarkerPosition(latLng);
			geocodePosition(latLng);

			// Add dragging event listeners.
			google.maps.event.addListener(marker, "dragstart", function() {
				updateMarkerAddress("Dragging...");
			});

			google.maps.event.addListener(marker, "drag", function() {
				updateMarkerStatus("Dragging...");
				updateMarkerPosition(marker.getPosition());
				lat = $("#PlacesModel_lat").val(marker.getPosition().Ya)
				lng = $("#PlacesModel_lng").val(marker.getPosition().Za)
			});

			google.maps.event.addListener(marker, "dragend", function() {
				updateMarkerStatus("Drag ended");
				geocodePosition(marker.getPosition());
				lat = $("#PlacesModel_lat").val(marker.getPosition().Ya)
				lng = $("#PlacesModel_lng").val(marker.getPosition().Za)
			});
			
		}		
		
		initialize();
	});
	
	', CClientScript::POS_READY);