$(document).ready(function () {

	// CONSTRUCTION CALENDAR
	var closedDates = document.getElementById('closedDates').innerHTML;
	closedDates = closedDates.replace(/(?:\r\n|\r|\n)/g, '');
	closedDates = closedDates.trim();
	var closedDatesTab = closedDates.split(',');


	$('#booking-calendar').dateRangePicker({
		inline:false,
		singleDate : true,
		singleMonth: false,
		autoClose: true, 
		container: '#calendarContainer',
		alwaysOpen:false,
		language:'fr',
		startOfWeek: 'monday',
		format: 'DD/MM/YYYY',
		customTopBar: ' ',
		startDate: moment().format('DD-MM-YYYY'),
		beforeShowDay: function(t)
		{
			// Disable les dates de fermeture + Samedi/dimanche selon BDD
		    var Tsrting = ("0" + t.getDate()).slice(-2) + "/" + ("0"+(t.getMonth()+1)).slice(-2) + "/" + t.getFullYear();
		    var isDisabled = ($.inArray(Tsrting, closedDatesTab) != -1);

			if (document.getElementById('isOpenSaturday').innerHTML == '' && document.getElementById('isOpenSunday').innerHTML == ''){
				var valid = t.getDay() != 0 && t.getDay() != 6 && !isDisabled;
				var _tooltip = valid ? '' : 'Fermé';
			}else if(document.getElementById('isOpenSaturday').innerHTML == 1 && document.getElementById('isOpenSunday').innerHTML == ''){
				var valid =t.getDay() != 0 && !isDisabled; 
				var _tooltip = valid ? '' : 'Fermé';
			}else if(document.getElementById('isOpenSaturday').innerHTML == '' && document.getElementById('isOpenSunday').innerHTML == 1){
				var valid = t.getDay() != 6 && !isDisabled; 
				var _tooltip = valid ? '' : 'Fermé';
			}else{
				var valid = !isDisabled;
				var _tooltip = valid ? '' : 'Fermé';
			}
			
			return [valid,'',_tooltip];
			
		}
	}).bind('datepicker-change',function(event,obj){
		/* This event will be triggered when second date is selected */
		document.getElementById('booking_confirmer').disabled = false;
	});

});




