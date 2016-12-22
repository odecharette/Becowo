$(document).ready(function () {


// CONSTRUCTION CALENDAR
var duree = document.querySelector('input[name="booking-duration"]:checked').value;
loadCalendar(duree);

// CONSTRUCTION HORAIRE
// http://seiyria.com/bootstrap-slider/
loadTime(duree);

// CONSTRUCTION PEOPLE
var mySliderPeople = $("#booking-people").slider({});

// Prix par défaut
loadPrice(duree);

	// On reload des éléments à chaque fois que la duration change :
	$('#booking-duration').on('change', function() { 
	    var duree = document.querySelector('input[name="booking-duration"]:checked').value;
	    // reset calendar
		$('#booking-calendar').data('dateRangePicker').destroy();
	    loadCalendar(duree);
	    loadTime(duree);
	    loadPrice(duree);
	});

    // On désactive le bouton 'confirmer' tant que le mois n'est pas sélectionné (pour tous les autres champs il y a une valeur par défaut)
    if(duree == 'Mois')
    {
        document.getElementById('booking_confirmer').disabled = true;
    }

});





// config : http://longbill.github.io/jquery-date-range-picker/
function loadCalendar(duree)
{
	var closedDates = document.getElementById('closedDates').innerHTML;
	closedDates = closedDates.replace(/(?:\r\n|\r|\n)/g, '');
	closedDates = closedDates.trim();
	var closedDatesTab = closedDates.split(',');

	if(duree == 'Heure' || duree == 'Demi journée' || duree == 'Journée') {

		$('#booking-calendar').dateRangePicker({
			inline:true,
			singleDate : true,
			singleMonth: true,
			container: '#calendarContainer',
			alwaysOpen:true,
			language:'fr',
			startOfWeek: 'monday',
			format: 'DD-MM-YYYY',
			customTopBar: ' ',
			startDate: moment().format('DD-MM-YYYY')
		}).bind('datepicker-change',function(event,obj){
			/* This event will be triggered when second date is selected */
			 loadPrice(duree);
		});

	}else if (duree == 'Semaine'){

		$('#booking-calendar').dateRangePicker({
			inline:true,
			container: '#calendarContainer',
			alwaysOpen:true,
			language:'fr',
			startOfWeek: 'monday',
			format: 'DD-MM-YYYY',
			separator: ' au ',
			stickyMonths: true,
			customTopBar: ' ',
			minDays: 5,
			maxDays: 7,
			startDate: moment().format('DD-MM-YYYY')
		}).bind('datepicker-change',function(event,obj){
			/* This event will be triggered when second date is selected */
			 loadPrice(duree);
		});

	}else if (duree == 'Mois'){

		$('#booking-calendar').dateRangePicker({
			inline:true,
			container: '#calendarContainer',
			alwaysOpen:true,
			language:'fr',
			startOfWeek: 'monday',
			format: 'DD-MM-YYYY',
			separator: ' au ',
			stickyMonths: true,
			customTopBar: ' ',
			minDays: 28,
			maxDays:31,
			startDate: moment().format('DD-MM-YYYY')
		}).bind('datepicker-change',function(event,obj){
			/* This event will be triggered when second date is selected */
			loadPrice(duree);
            document.getElementById('booking_confirmer').disabled = false;
		});

	};


	// TO DO
	// Désactiver samedi / dimanche selon BDD
	// Désactiver jours fermés
}

function loadTime(duree){

    // on doit reset le slider à chaque fois sinon ca bug
    // $("#booking-time-slider").slider().data('slider').destroy();

	if(duree == 'Heure'){ 
		document.getElementById('calendar-halftime').style.display = 'none';
		document.getElementById('calendar-time').style.display = 'block';

		var ouverture = document.getElementById('openHour').split(':');
		var ouvertureMinutes = Number(ouverture[0]) * 60 + Number(ouverture[1]);
		var fermeture = document.getElementById('closeHour').split(':');
		var fermetureMinutes = Number(fermeture[0]) * 60 + Number(fermeture[1]);

		var mySliderTime = $("#booking-time-slider").slider({
		range: true,
    	min: ouvertureMinutes,	// every values are in minutes
    	max: fermetureMinutes,
    	step: 60,
    	value: [ouvertureMinutes, ouvertureMinutes+60]

		});

        //Initi selected heures
        var valeursMinutes = mySliderTime.data('slider').getValue();
        valeursTransformed = transformSliderValuesIntoHourMinute(valeursMinutes);
        remplirMinMaxTimeSlider(valeursTransformed);

		mySliderTime.on('slide', function(ev){	

            var valeursMinutes = mySliderTime.data('slider').getValue();

    		var nbHeures = (valeursMinutes[1] - valeursMinutes[0])/60;
    		document.getElementById('nbHeures').innerHTML = nbHeures;

            valeursTransformed = transformSliderValuesIntoHourMinute(valeursMinutes);
            remplirMinMaxTimeSlider(valeursTransformed);

    		loadPrice(duree);
		});


		//on désactive les tooltip car le txt affiché ne convient pas
		document.getElementsByClassName('tooltip-main')[0].style.display = 'none';
		document.getElementsByClassName('tooltip-inner')[0].style.display = 'none';
		document.getElementsByClassName('tooltip-arrow')[0].style.display = 'none';
		loadPrice(duree);

	}else if(duree == 'Demi journée'){ 
		document.getElementById('calendar-time').style.display = 'none';
		document.getElementById('calendar-halftime').style.display = 'block';
	}else{
		document.getElementById('calendar-time').style.display = 'none';
		document.getElementById('calendar-halftime').style.display = 'none';
	}

}

function loadPrice(duree){

	var prix = document.getElementById('price' + duree).innerHTML;

	var total = prix;
	var officeType = document.getElementById('officeType');
	var nbHeures = document.getElementById('nbHeures').innerHTML;
	var nbPeople = document.getElementById('booking-people').value;

	if(duree == 'Heure'){
		total = prix * nbHeures;
	}else{
		total = prix;
	}

	if(officeType == 'Open space'){
		total = total * nbPeople;
	}

	var tva = document.getElementById('tva').innerHTML;
	document.getElementById('price-excl-tax').value = total;
	document.getElementById('price-incl-tax').value = total * (1 + tva/100);
    document.getElementById('price-excl-tax-div').innerHTML = total;
    document.getElementById('price-incl-tax-div').innerHTML = total * (1 + tva/100);

}

function transformSliderValuesIntoHourMinute(valeurs)
{
    var hours1 = Math.floor(valeurs[0] / 60);
    var minutes1 = valeurs[0] - (hours1 * 60);

    if (hours1 < 10) hours1 = '0' + hours1;
    if (minutes1.length == 1) minutes1 = '0' + minutes1;
    if (minutes1 == 0) minutes1 = '00';

    var hours2 = Math.floor(valeurs[1] / 60);
    var minutes2 = valeurs[1] - (hours2 * 60);

    if (hours2 < 10) hours2 = '0' + hours2;
    if (minutes2.length == 1) minutes2 = '0' + minutes2;
    if (minutes2 == 0) minutes2 = '00';

    valeurs[0] = hours1 + ':' + minutes1;
    valeurs[1] = hours2 + ':' + minutes2;
    return valeurs;
}

function remplirMinMaxTimeSlider(valeurs){

    document.getElementById('time-min').innerHTML = valeurs[0];
    document.getElementById('time-max').innerHTML = valeurs[1];
}


