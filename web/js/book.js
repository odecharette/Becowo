	document.getElementById("dateHeure").style.display = 'none';
    document.getElementById("dateDemiJournee").style.display = 'none';
    document.getElementById("dateJournee").style.display = 'none';
    document.getElementById("dateSemaine").style.display = 'none';
    document.getElementById("dateMois").style.display = 'none';

	function goBooking($officeName)
    {
        document.getElementById("booking_titre").innerHTML = 'Réservation pour ' + $officeName;
    }        
        
    function radioClick(radioDuree){
        
        switch(radioDuree.value)
        {
            case "Heure":
                document.getElementById("dateHeure").style.display = 'block';
                document.getElementById("dateDemiJournee").style.display = 'none';
                document.getElementById("dateJournee").style.display = 'none';
                document.getElementById("dateSemaine").style.display = 'none';
                document.getElementById("dateMois").style.display = 'none';
                break;
            case "DemiJournee":
                document.getElementById("dateHeure").style.display = 'none';
                document.getElementById("dateDemiJournee").style.display = 'block';
                document.getElementById("dateJournee").style.display = 'none';
                document.getElementById("dateSemaine").style.display = 'none';
                document.getElementById("dateMois").style.display = 'none';
                break;
            case "Journee":
                document.getElementById("dateHeure").style.display = 'none';
                document.getElementById("dateDemiJournee").style.display = 'none';
                document.getElementById("dateJournee").style.display = 'block';
                document.getElementById("dateSemaine").style.display = 'none';
                document.getElementById("dateMois").style.display = 'none';
                break;
            case "Semaine":
                document.getElementById("dateHeure").style.display = 'none';
                document.getElementById("dateDemiJournee").style.display = 'none';
                document.getElementById("dateJournee").style.display = 'none';
                document.getElementById("dateSemaine").style.display = 'block';
                document.getElementById("dateMois").style.display = 'none';
                break;
            case "Mois":
                document.getElementById("dateHeure").style.display = 'none';
                document.getElementById("dateDemiJournee").style.display = 'none';
                document.getElementById("dateJournee").style.display = 'none';
                document.getElementById("dateSemaine").style.display = 'none';
                document.getElementById("dateMois").style.display = 'block';
                break;                    
        }
    }

jQuery(function($){

	// documentation : http://api.jqueryui.com/datepicker/
	$.datepicker.setDefaults($.datepicker.regional['fr']);

	$('#pickerHeure').datepicker({
		dateFormat: 'dd/mm/yy',
		minDate: 0
	});

	$('#pickerJournee').datepicker({
		dateFormat: 'dd/mm/yy',
		minDate: 0
	});

	$('.pickerSemaine').weekpicker({
		dateFormat: 'dd/mm/yy',
		minDate: 0
	});

	$('.pickerMois').datepicker({
		dateFormat: 'MM yy'
	});

});