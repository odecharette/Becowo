	document.getElementById("dateHeure").style.display = 'none';
    document.getElementById("dateDemiJournee").style.display = 'none';
    document.getElementById("dateJournee").style.display = 'none';
    document.getElementById("dateSemaine").style.display = 'none';
    document.getElementById("dateMois").style.display = 'none';

	function goBooking(officeName)
    {
        document.getElementById("officeSelected").innerHTML = officeName;
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
                document.getElementById("durationSelected").innerHTML = "Heure";
                break;
            case "DemiJournee":
                document.getElementById("dateHeure").style.display = 'none';
                document.getElementById("dateDemiJournee").style.display = 'block';
                document.getElementById("dateJournee").style.display = 'none';
                document.getElementById("dateSemaine").style.display = 'none';
                document.getElementById("dateMois").style.display = 'none';
                document.getElementById("durationSelected").innerHTML = "Demi Journée";
                break;
            case "Journee":
                document.getElementById("dateHeure").style.display = 'none';
                document.getElementById("dateDemiJournee").style.display = 'none';
                document.getElementById("dateJournee").style.display = 'block';
                document.getElementById("dateSemaine").style.display = 'none';
                document.getElementById("dateMois").style.display = 'none';
                document.getElementById("durationSelected").innerHTML = "Journée";
                break;
            case "Semaine":
                document.getElementById("dateHeure").style.display = 'none';
                document.getElementById("dateDemiJournee").style.display = 'none';
                document.getElementById("dateJournee").style.display = 'none';
                document.getElementById("dateSemaine").style.display = 'block';
                document.getElementById("dateMois").style.display = 'none';
                document.getElementById("durationSelected").innerHTML = "Semaine";
                break;
            case "Mois":
                document.getElementById("dateHeure").style.display = 'none';
                document.getElementById("dateDemiJournee").style.display = 'none';
                document.getElementById("dateJournee").style.display = 'none';
                document.getElementById("dateSemaine").style.display = 'none';
                document.getElementById("dateMois").style.display = 'block';
                document.getElementById("durationSelected").innerHTML = "Mois";
                break;                    
        }
    }

    function radioDemiJourneeClick(radioDuree){
    	document.getElementById("durationDetailSelected").innerHTML = radioDuree.value;
    }

    function heureClick(duree){
    	document.getElementById("durationDetailSelected").innerHTML = 'De ';
    	document.getElementById("durationDetailSelected").innerHTML += document.getElementById("heure_start").value;
    	document.getElementById("durationDetailSelected").innerHTML += ':';
    	document.getElementById("durationDetailSelected").innerHTML += document.getElementById("min_start").value;
    	document.getElementById("durationDetailSelected").innerHTML += ' à ';
    	document.getElementById("durationDetailSelected").innerHTML += document.getElementById("heure_end").value;
    	document.getElementById("durationDetailSelected").innerHTML += ':';
    	document.getElementById("durationDetailSelected").innerHTML += document.getElementById("min_end").value;
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

