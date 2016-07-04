jQuery(function($){

	// documentation : http://api.jqueryui.com/datepicker/
	$.datepicker.setDefaults($.datepicker.regional['fr']);
	$('#datepicker').datepicker({
		dateFormat: 'dd/mm/yy',
		minDate: 0
	});



});