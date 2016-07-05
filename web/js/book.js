	document.getElementById("dateHeure").style.display = 'none';
    document.getElementById("dateDemiJournee").style.display = 'none';
    document.getElementById("dateJournee").style.display = 'none';
    document.getElementById("dateSemaine").style.display = 'none';
    document.getElementById("dateMois").style.display = 'none';

	function goBooking(officeName)
    {
        document.getElementById("officeSelected").innerHTML = officeName;
        // document.getElementById("section_features_table").style.display = 'none';
    }        

    function selectDuree(duree, bureau)
    {
    	document.form.optionsDuree.value = duree;
    	document.getElementById("officeSelected").innerHTML = bureau;
    	radioClick(document.form.optionsDuree);
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
            case "DemiJournée":
                document.getElementById("dateHeure").style.display = 'none';
                document.getElementById("dateDemiJournee").style.display = 'block';
                document.getElementById("dateJournee").style.display = 'none';
                document.getElementById("dateSemaine").style.display = 'none';
                document.getElementById("dateMois").style.display = 'none';
                break;
            case "Journée":
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
        document.getElementById("durationSelected").innerHTML = radioDuree.value;
        calculatePrice();
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

    	var debut = new Date(0, 0, 0, document.getElementById("heure_start").value, document.getElementById("min_start").value, 0);
    	var fin = new Date(0, 0, 0, document.getElementById("heure_end").value, document.getElementById("min_end").value, 0);
    	var nbHeure = (fin.getTime() - debut.getTime())/60/1000;
    	if(nbHeure%60 != 0 ){    		
    		document.getElementById("error_msg").innerHTML = "L'heure de fin n'est pas correcte";
    	}
    	else
    		document.getElementById("error_msg").innerHTML = "";
    		document.getElementById("nbHeure").innerHTML = nbHeure;
    		calculatePrice();
    }

    function calculatePrice()
    {
    	var duree = document.getElementById("durationSelected").innerHTML;
    	var bureau = document.getElementById("officeSelected").innerHTML;
    	var tag = "price_" + duree + "_" + bureau;    	
    	var prixUnitaire = document.getElementById(tag).innerHTML;
    	var prix = 0;
    	if(duree == "Heure")
    		prix = prixUnitaire * (document.getElementById("nbHeure").innerHTML/60);
    	else
    		prix = prixUnitaire;

    	document.getElementById("price").innerHTML = prix + ' €';
    }

jQuery(function($){

	// documentation : http://api.jqueryui.com/datepicker/
	$.datepicker.setDefaults($.datepicker.regional['fr']);

	$('#dateHeure').datepicker({
		dateFormat: 'dd/mm/yy',
		minDate: 0,
		altField: "#dateSelected"
	});

	$('#dateDemiJournee').datepicker({
		dateFormat: 'dd/mm/yy',
		minDate: 0,
		altField: "#dateSelected"
	});
	$('#dateJournee').datepicker({
		dateFormat: 'dd/mm/yy',
		minDate: 0,
		altField: "#dateSelected"
	});

	$('#dateSemaine').weekpicker({
		dateFormat: 'dd/mm/yy',
		minDate: 0
	});

	$('#dateMois').datepicker({
		dateFormat: 'MM yy',
		altField: "#dateSelected"
	});

});

