var id;
var DAY;
var WEEK = {
	monday: { day_and_night: "24/7" },
	tuesday: { day_and_night: "24/7" },
	wednesday: { day_and_night: "24/7" },
	thursday: { day_and_night: "24/7" },
	friday: { day_and_night: "24/7" },
	saturday: { day_and_night: "24/7" },
	sunday: { day_and_night: "24/7" }
};
var mode = "run";
var _timeTo = "last_client";
var weekArr = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
var place_id = $('button.btn[data-toggle="modal"]').data('place-id');
var JsonUpdate;
$(document).ready(function(){
	$('#place_timetable .controls button').on('click', function(){
		if($("#show_popup_timetable").size() == 0){
			get_schedule_popup();
			$('body').append('<div class="modal-backdrop in"></div>');
		}
		else{
			$("show_popup_timetable").show();
		}
	});
});

function get_schedule_popup(){
	var request = $.ajax({
		//in production delete "index.php"
		url: "/index.php/ycm/places/timetablePopup/",
		type: "POST",
		data: {place_id: place_id}
	});

	request.done(function(data) {
		if(data != ''){
			$('#timetable').append("<div id='show_popup_timetable'>"+data+"</div>");
			closePopup();
			show_time_selection();
			save_changes();
			$('.modal').show();
			JsonUpdate = $('#show_popup_timetable .modal-body table').data('json-update');
			updateJson();
		}
	});

	request.fail(function(jqXHR, textStatus) {
		alert(textStatus); 
    });
}

function show_time_selection(){
	$('.modal tbody tr').on('click', function(){
		DAY = $(this).data('day');
		if(!WEEK[DAY].day_and_night){
			from = WEEK[DAY].time_from.split(":");
			hourFrom = from[0];
			minuteFrom = from[1];
			to = WEEK[DAY].time_to;
			if(to == "Last client"){
				hourTo = null;
				minuteTO = null;
			} else {
				to = to.split(":");
				hourTo = to[0];
				minuteTO = to[1];
			}
		} else {
			hourFrom = null;
			minuteFrom = null;
			hourTo = null;
			minuteTO = null;
		}
		html = '<div id="timing">'
				+'<div class="modal" style="width: 300px;">'
					+'<div class="modal-body">'
						+'<div id="mode" style="width: 160px; margin: 15px;">'
							+'<input type="radio" name="mode" data-name="run"/> <span style="margin-right: 15px;">Choose time</span>'
							+'<input type="radio" name="mode" data-name="24/7" /> 24/7'
						+'</div>'
						+'<div class="clear" style="clear: both;"></div>'
						+'<div id="row">'
							+'<div id="time_from">'
								+'<h5 style="float: left; margin-right: 20px;">From:</h5>'
								+select_hours(hourFrom)+' : '+select_minutes(minuteFrom)
							+'</div>'
							+'<div class="clear" style="clear: both;"></div>'
							+'<div id="time_to">'
								+'<h5 style="float: left; margin: 0 20px 0 0;">To:</h5>'
								+'<input type="radio" name="time_to" data-name="select_time"/><span style="margin-right: 15px;">Select time</span>'
								+'<input type="radio" value="1" name="time_to" data-name="last_client" />Last client'
							+'</div>'
							+'<div class="clear" style="clear: both;"></div>'
							+'<div class="time_to" style="display: none;">'+select_hours(hourTo)+' : '+select_minutes(minuteTO)+'</div>'
						+'</div>'
						+'<div class="clear" style="clear: both;"></div>'
					+'</div>'
					+'<div class="modal-footer">'
						+'<a href="#" class="btn btn-primary" id="ok">Ok</a>'
						+'<select name="type_copy" style="width: 135px;">'
							+'<option value="this_day">This day</option>'
							+'<option value="to_all_days">To All Days</option>'
							+'<option value="to_weekdays">To Weekdays</option>'
						+'</select>'
						+'<a href="#" class="btn" id="cancel">Cancel</a>'	
					+'</div>'
				+'</div>'
			+'</div>';
		$('#show_popup_timetable').append(html);
		if(WEEK[DAY].day_and_night){
			$('#mode :radio[data-name="24/7"]').attr('checked','checked');
		} else {
			$('#mode :radio[data-name="run"]').attr('checked','checked');
			if(WEEK[DAY].time_to == "Last client"){
				$('#time_to :radio[data-name="last_client"]').attr('checked','checked');
			} else {
				$('#time_to :radio[data-name="select_time"]').attr('checked','checked');
				$('.time_to').show();
			}
		}
		toggleMode();
		toggleTimeTo();
		OK();
		CANCEL();
		mode = $('#timing .modal-body :radio:checked').data('name');
		_timeTo = $('#time_to :radio').data('name');
		showTimeChoose(mode);
	});
}

function toggleMode(){
	$('#timing #mode :radio').on('click', function(){
		mode = $(this).data('name');
		showTimeChoose(mode);
	});
}

function toggleTimeTo(){
	$('#timing #time_to :radio').on('click', function(){
		_timeTo = $(this).data('name');
		if(_timeTo == 'last_client'){
			$('#timing .time_to').hide();
		} else if(_timeTo == 'select_time'){
			$('#timing .time_to').show();
		}
	});
}

function showTimeChoose(_type){
	if(_type == 'run'){
		$('#row').show();
	} else if(_type == '24/7'){
		$('#row').hide();
	}
}

function updateJson() {
	if(JsonUpdate){
		for(var i = 0; i < weekArr.length; i++){
			dayVal = $('#show_popup_timetable .modal-body table tbody tr[data-day="'+weekArr[i]+'"] td[name="edit_run"]').text();
			if(dayVal != '24/7'){
				timePeriod = dayVal.split(" - ");
				WEEK[weekArr[i]] = {
					time_from: timePeriod[0],
					time_to: timePeriod[1]
				}
				delete WEEK[weekArr[i]].day_and_night;
			}
		}
	}
	else
		console.log(false)
}

function saveJson(){
	type_copy = $('.modal-footer select[name="type_copy"]').val();
	if(mode == "24/7"){
		switch (type_copy) {
			case 'to_all_days':
				for(var i = 0; i < weekArr.length; i++){
					WEEK[weekArr[i]] = {
						day_and_night: '24/7'
					}
				}
				break;
			case 'to_weekdays':
				WEEK[DAY] = {
					day_and_night: '24/7'
				}
				break;
			case 'this_day':
			default:	
				WEEK[DAY] = {
					day_and_night: '24/7'
				}
				break;
		}
	} else if(mode == "run"){
		time_from_hour = $('#row #time_from select[name="hour"]:visible').val();
		time_from_minute = $('#row #time_from select[name="minute"]:visible').val();
		time_from = time_from_hour + ":" +time_from_minute;
		if(_timeTo == "last_client"){
			time_to = "Last client";
		} else if(_timeTo == "select_time"){
			time_to_hour = $('#row .time_to select[name="hour"]:visible').val();
			time_to_minute = $('#row .time_to select[name="minute"]:visible').val();
			time_to = time_to_hour + ":" +time_to_minute;
		}
				
		switch (type_copy) {
			case 'to_all_days':
				for(var i = 0; i < weekArr.length; i++){
					WEEK[weekArr[i]] = {
						time_from: time_from,
						time_to: time_to
					}
					delete WEEK[weekArr[i]].day_and_night;
				}
				break;
			case 'to_weekdays':
				WEEK[DAY] = {
					time_from: time_from,
					time_to: time_to
				}
				delete WEEK[DAY].day_and_night;
				break;
			case 'this_day':
			default:	
				WEEK[DAY] = {
					time_from: time_from,
					time_to: time_to
				}
				delete WEEK[DAY].day_and_night;
				break;
		}
	}
}

function refreshTable(){
	$('#show_popup_timetable .modal .modal-body tbody tr').each(function(item){
		curDay = $(this).data('day');
		if(WEEK[curDay]){
			if(WEEK[curDay].day_and_night)
				timePeriodHTML = WEEK[curDay].day_and_night;
			else if(WEEK[curDay].time_from && WEEK[curDay].time_to)
				timePeriodHTML = WEEK[curDay].time_from +' - '+WEEK[curDay].time_to;
			$(this).find('td[name="edit_run"]').html(timePeriodHTML);
		}
		else{
			console.log("whereeeeeee");
		}
	});
}

function save_changes(){
	$('#show_popup_timetable #save_changes').on('click', function(){
		//in production delete "index.php"
		url = "/index.php/ycm/places/timetableSave/";
		$.post(url, { timetable: WEEK, place_id: place_id }, function(data) {
			if(data == "no")
				alert("Not saved! Retry.");
			else alert("Saved");
		});
		$('#show_popup_timetable').remove();
		$('div.modal-backdrop.in').remove();
		return false;
	});
}

function OK(){
	$('#show_popup_timetable #timing #ok').on('click', function(){
		saveJson();
		refreshTable();
		removeTiming();
		return false;
	});
}

function CANCEL(){
	$('#show_popup_timetable #timing #cancel').on('click', function(){
		removeTiming();
		return false;
	});
}

function removeTiming(){
	$('#show_popup_timetable #timing').remove();
}

function select_hours(_hour){
	html = '<select name="hour" style="width: 53px; margin-top: 5px;">';
	for(var i = 0; i < 24; i++){
		if(i < 10){
			isSelected = _hour == "0"+i ? 'selected' : '';
			html += '<option value="0'+i+'" '+isSelected+'>0'+i+'</option>';
		} else {
			isSelected = _hour == i ? 'selected' : '';
			html += '<option value="'+i+'" '+isSelected+'>'+i+'</option>';
		}
	}
	html += '</select>';
	return html;
}

function select_minutes(_minute){
	html = '<select name="minute" style="width: 53px; margin-top: 5px;">';
	for(var i = 0; i < 60; i++){
		if(i < 10){
			isSelected = _minute == "0"+i ? 'selected' : '';
			html += '<option value="0'+i+'" '+isSelected+'>0'+i+'</option>';
		} else {
			isSelected = _minute == i ? 'selected' : '';
			html += '<option value="'+i+'" '+isSelected+'>'+i+'</option>';
		}
	}
	html += '</select>';
	return html;
}

function closePopup(){
	$('#show_popup_timetable .close').on('click',function(){
		$('#show_popup_timetable').hide();
		$('div.modal-backdrop.in').remove();
	});
}