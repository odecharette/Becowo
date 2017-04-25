$(document).ready(function () {

// CONSTRUCTION CALENDAR
loadCalendar(getDuree());

// CONSTRUCTION HORAIRE
// http://seiyria.com/bootstrap-slider/
loadTime(getDuree());

// CONSTRUCTION PEOPLE
var mySliderPeople = $("#booking-people").slider({});

mySliderPeople.on('change', function(ev){	
    document.getElementById('nbPeople').innerHTML = mySliderPeople.data('slider').getValue();
    loadPrice(getDuree());
});

// Prix par défaut
loadPrice(getDuree());

// On reload des éléments à chaque fois que la duration change :
$('#booking-duration').on('change', function() { 
    // reset calendar
	$('#booking-calendar').data('dateRangePicker').destroy();
    loadCalendar(getDuree());
    loadTime(getDuree());
    loadPrice(getDuree());
});

if(document.querySelector('input[id="booking-calendar"]').value != ''){
	// Cas où on revient sur la page
	document.getElementById('recapDate').innerHTML = loadRecapDate(getDuree(),document.querySelector('input[id="booking-calendar"]').value);
	document.getElementById('booking_confirmer').disabled = false;
}else{
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
		loadPrice(getDuree());
		document.getElementById('recapDate').innerHTML = loadRecapDate(getDuree(), obj.value);
		document.getElementById('booking_confirmer').disabled = false;
	});

}

function loadTime(duree){

    // on doit reset le slider à chaque fois sinon ca bug et donc réinitialiser le nbHeures
    $("#booking-time-slider").slider().data('slider').destroy();
	document.getElementById('nbHeures').innerHTML = 1;

	if(duree == 'Heure'){ 
		document.getElementById('calendar-halftime').style.display = 'none';
		document.getElementById('calendar-time').style.display = 'block';

		var ouverture = document.getElementById('openHour').innerHTML.split(':');
		var ouvertureMinutes = Number(ouverture[0]) * 60 + Number(ouverture[1]);
		var fermeture = document.getElementById('closeHour').innerHTML.split(':');
		var fermetureMinutes = Number(fermeture[0]) * 60 + Number(fermeture[1]);

		var mySliderTime = $("#booking-time-slider").slider({});

        //Initi selected heures
        var valeursMinutes = mySliderTime.data('slider').getValue();
        valeursTransformed = transformSliderValuesIntoHourMinute(valeursMinutes);
        remplirMinMaxTimeSlider(valeursTransformed);

		mySliderTime.on('change', function(ev){	

            var valeursMinutes = mySliderTime.data('slider').getValue();

    		var nbHeures = (valeursMinutes[1] - valeursMinutes[0])/60;
    		document.getElementById('nbHeures').innerHTML = nbHeures;

            valeursTransformed = transformSliderValuesIntoHourMinute(valeursMinutes);
            remplirMinMaxTimeSlider(valeursTransformed);

    		loadPrice(getDuree());
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
// console.info('*** loadPrice');
	var prix = document.getElementById('price' + duree).innerHTML;

	var total = prix;
	var officeType = document.getElementById('officeType').innerHTML;
	var nbHeures = document.getElementById('nbHeures').innerHTML;
	var nbPeople = document.getElementById('booking-people').value;
// console.info('prix : ' + prix);
// console.info('duree : ' + duree);
// console.info('officeType : ' + officeType);
// console.info('nb Heures : ' + nbHeures);
// console.info('nbPeople : ' + nbPeople);

	if(duree == 'Heure'){
		total = prix * nbHeures;
		// console.info('duree heure donc total : ' + total);
	}else{
		total = prix;
		// console.info('duree NOT heure donc total : ' + total);
	}

	if(officeType == 'Espace partagé'){
		total = total * nbPeople;
		// console.info('officeType espace partagé donc total : ' + total);
	}
	var tva = document.getElementById('tva').innerHTML;
	var tot = precise_round(total, 2);
	var totTTC = precise_round(tot * (1 + tva/100), 2);
	document.getElementById('price-excl-tax').value = tot;
	document.getElementById('price-incl-tax').value = totTTC;
    document.getElementById('price-excl-tax-div').innerHTML = tot;
    document.getElementById('price-incl-tax-div').innerHTML = totTTC;
    document.getElementById('booking-price-excl-tax').innerHTML = tot;

}

function transformSliderValuesIntoHourMinute(valeurs)
{

	if(String(valeurs[0]).indexOf(':') == -1){
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
	}
    return valeurs;
}

function remplirMinMaxTimeSlider(valeurs){

    document.getElementById('time-min').innerHTML = valeurs[0];
    document.getElementById('time-max').innerHTML = valeurs[1];
}

function precise_round(num, decimals) {
   var t = Math.pow(10, decimals);   
   return (Math.round((num * t) + (decimals>0?1:0)*(mySign(num) * (10 / Math.pow(100, decimals)))) / t).toFixed(decimals);
}

function mySign(num) {
	// IE does not support method sign here
	if (typeof Math.sign === 'undefined') {
		if (num > 0) {
			return 1;
		}
		if (num < 0) {
			return -1;
		}
		return 0;
	}
	return Math.sign(num);
}

function loadRecapDate(duree, value)
{
	if(duree == "Mois")
	{
		var d = Date.parse(value);
		d = d.add(1).months();
		d = d.add(-1).days();
		d = d.toLocaleDateString();

		document.getElementById('dateEnd').value = d;
		return 'Du ' + value + " au " + d;
	}else if(duree == 'Semaine')
	{
		var d = Date.parse(value).add(6).days();
		d = d.toLocaleDateString();

		document.getElementById('dateEnd').value = d;
		return 'Du ' + value + " au " + d;
	}else
	{
		document.getElementById('dateEnd').value = value;
		return 'Le ' + value;
	}
}

function getDuree()
{
	return document.querySelector('input[name="booking-duration"]:checked').value;
}

// Gestion des prestations

// $('.PartnerChoice li').click(function(e){
//     $('.PartnerChoiceBtn').text(this.className);
// });
$('.OfferChoice li').click(function(e){
	var txtTab = this.className.split('-');
	$('.OfferChoiceBtn').text(txtTab[0]);
    $('#prestaName').text(txtTab[0]);
    $('#prestaPrice').text(txtTab[1]);
});

$('#addPartnerOffer').click(function(e){
	e.preventDefault();

	if($('.OfferChoiceBtn').text().indexOf('Choisir') == 0 ) 
	{
		$('#OfferChoiceError').show();
	}else if($('#prestaNbPers').val() < 1 || $('#prestaNbPers').val() == '' )
	{
		$('#prestaNbPersError').show();
		$('#OfferChoiceError').hide();
	}else
	{
		$('#prestaNbPersError').hide();
		$('#OfferChoiceError').hide();
		// On crée une liste avec en class le prix, et en value le nom de la presta choisie
		$('#listPartnerOffers').append( 
				'<div class="' + $('#prestaPrice').text() +
				'" name="' + $('#prestaName').text() +
				'">' +
				$('#prestaName').text() + 
				'<a href="#" class="itemToDelete" style="color:red">' + 
				' <i class="fa fa-trash" aria-hidden="true"></i></a>' + 
				'<br>'+
				'</div>');
		$('[id^=myModalPresta]').modal('hide');

		calculatePriceWithPresta();
	};

});

$(document).on('click','.itemToDelete',function(e){
	e.preventDefault();
    $(this).parent().remove();

    calculatePriceWithPresta();
});

function calculatePriceWithPresta()
{
	// Add or remove Offer price to booking price

	var nbPers = document.getElementById('prestaNbPers').value;
	var tva = document.getElementById('tva').innerHTML;
	var totPresta = 0;
	var list = "";
	$("#listPartnerOffers>div").each(function(index, value){
     	// pour chaque div item dans la liste : on récup le prix et le nom
     	var price = value.className;
		totPresta += (parseFloat(price) * nbPers);
		// on réunit l'input pour passer la liste au controller
     	list += value.getAttribute('name') + ',';
 	});
	document.getElementById('listPartnerOffersToReserve').value = list;

	var existingBookingPrice = document.getElementById('booking-price-excl-tax').innerHTML;
	var totHT = precise_round(parseFloat(existingBookingPrice) + totPresta, 2);
	var totTTC = precise_round(totHT * (1 + tva/100), 2);
	document.getElementById('price-excl-tax').value = totHT;
	document.getElementById('price-incl-tax').value = totTTC;
    document.getElementById('price-excl-tax-div').innerHTML = totHT;
    document.getElementById('price-incl-tax-div').innerHTML = totTTC;
}
