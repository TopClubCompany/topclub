var id;
var DAY;
var WEEK = {
	monday: {},
	tuesday: {},
	wednesday: {},
	thursday: {},
	friday: {},
	saturday: {},
	sunday: {}
};
var weekArr = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
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
		type: "GET"
	});

	request.done(function(data) {
		if(data != ''){
			$('#timetable').append("<div id='show_popup_timetable'>"+data+"</div>");
			closePopup();
			show_time_selection();
			$('.modal').show();
		}
	});

	request.fail(function(jqXHR, textStatus) {
		alert(textStatus); 
    });
}

function closePopup(){
	$('#show_popup_timetable .close').on('click',function(){
		$('#show_popup_timetable').hide();
		$('div.modal-backdrop.in').remove();
	});
}

function show_time_selection(){
	$('.modal td[name="edit_run"]').on('click', function(){
		DAY = $(this).parent().data('day');
		html = '<div id="timing"><div class="modal">'
	+'<div class="modal-body">'
		+'<div id="running">'
			+'<input type="radio" value=1 name="run" checked/> Running<br />'
	+row_time()
+'<div class="clear"></div>'
+'<span id="add_another"> + Add another time period</span>'
+'<div id="not_running">'
+'<input type="radio" value=1 name="not_run" /> Not running'
+'</div>'
+'</div>'
  +'<div class="modal-footer">'
	+'<a href="#" class="btn btn-primary" id="ok">Ok</a>'
	+'<select name="type_copy"><option value="copy">Copy</option><option value="to_all_days">To All Days</option><option value="to_weekdays">To Weekdays</option></select>'
	+'<a href="#" class="btn" id="cancel">Cancel</a>'	
  +'</div></div></div>';
		$('#show_popup_timetable').append(html);
		toggle_radio();
		add_row();
		remove_row();
		OK();
		CANCEL();
	});
}

function select_hours(){
	html = '<select name="hour">';
	for(var i = 0; i < 24; i++){
		if(i < 10)
			html += '<option value="0'+i+'">0'+i+'</option>';
		else
			html += '<option value="'+i+'">'+i+'</option>';
	}
	html += '</select>';
	return html;
}

function select_minutes(){
	html = '<select name="minute">';
	for(var i = 0; i < 60; i++){
		if(i < 10)
			html += '<option value="0'+i+'">0'+i+'</option>';
		else
			html += '<option value="'+i+'">'+i+'</option>';
	}
	html += '</select>';
	return html;
}

function row_time(index){
	if(!index)
		index = 0;
	row = '<div id="row_'+index+'" class="row"><div id="time_from">'+select_hours()+' : '+select_minutes()+'<span style="margin-left: 10px;">to</span></div>'
+'<div id="time_to">'+select_hours()+' : '+select_minutes()+'</div>'
+'<input type="text" name="discount" value="15" />%'
+'<span style="margin-left: 15px;" class="remove_row">Remove</span>'
+'</div></div>';
return row;
}

function toggle_radio(){
	$('#timing :radio').on('click', function(){
		$('#timing :radio').removeAttr('checked');
		$(this).attr('checked','checked');
	});
}

function add_row(){
	$('#add_another').on('click', function(){
		console.log('add row');
	
		countRow = $('#timing #running .row').size();
		insRow = row_time(countRow);
		if(countRow == 0)
			$('#timing #running br').after(insRow);
		else
			$('#timing #running .row:last').after(insRow);
		remove_row();
	});
}

function remove_row(){
	$('#timing #running .remove_row').on('click', function(){
		$(this).parent().remove();
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

function saveJson(){
	type_copy = $('.modal-footer select[name="type_copy"]').val();
	$('#running .row').each(function(index){
		time_from_hour = $('#row_'+index+' #time_from select[name="hour"]').val();
		time_from_minute = $('#row_'+index+' #time_from select[name="minute"]').val();
		time_to_hour = $('#row_'+index+' #time_to select[name="hour"]').val();
		time_to_minute = $('#row_'+index+' #time_to select[name="minute"]').val();
		discount = $('#row_'+index+' input[name="discount"]').val();
		if(type_copy == 'to_all_days'){
			for(var i = 0; i < weekArr.length; i++){
				WEEK[weekArr[i]][index] = {
					time_from_hour: time_from_hour,
					time_from_minute: time_from_minute,
					time_to_hour: time_to_hour,
					time_to_minute: time_to_minute,
					discount: discount
				}
			}
		}
		else{
			WEEK[DAY][index] = {
				time_from_hour: time_from_hour,
				time_from_minute: time_from_minute,
				time_to_hour: time_to_hour,
				time_to_minute: time_to_minute,
				discount: discount
			}
		}
	});
}

function refreshTable(){
	$('#show_popup_timetable .modal .modal-body tbody tr').each(function(item){
		curDay = $(this).data('day');
		if(WEEK[curDay][0]){
			timePeriodHTML = '<ul>';
			perBidHTML = '<ul>';
			for(var i in WEEK[curDay]){
				timePeriodHTML += '<li>'+WEEK[curDay][i].time_from_hour+':'+WEEK[curDay][i].time_from_minute+'-'
				+WEEK[curDay][i].time_to_hour+':'+WEEK[curDay][i].time_to_minute
				+'</li>';
				perBidHTML += '<li>'+WEEK[curDay][i].discount+'</li>';
			}
			timePeriodHTML += '</ul>';
			perBidHTML += '</ul>';
			$(this).find('td[name="edit_run"]').html(timePeriodHTML);
			$(this).find('td[name="discount"]').html(perBidHTML);
		}
		else{
			f = 1;
		}
	});
}