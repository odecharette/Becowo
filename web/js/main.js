// Google Analytics DEMO
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-77791149-2', 'auto');
  ga('send', 'pageview');

// End Google Analytics 

// Charge la mini carte google dans la page d'un WS, selon son adresse dynamique
var q=encodeURIComponent($('#address_ws').text());
       $('#map_ws')
        .attr('src','https://www.google.com/maps/embed/v1/place?key=AIzaSyACES16ClzyOdiVa9Ohd-_unkM5rvvbo7o&q='+q);

// Page d'un WS, envoye le commentaire et le vote en AJAX
$(function () {
    $("#comment_Envoyer").unbind("click").click(function(){
    	//Commentaire
    	$.ajax(Routing.generate('becowo_comment', {name: document.getElementById('wsName').innerHTML}), {
                    data: $('#comment-form').serialize(),
                    type: "POST",
                    success: function(data) {
                        $('#CommentResults').html(data);
                    },
                    error: function() {
                    	$('#CommentResults').html("Une erreur est survenue, veuillez réessayer plus tard");
                    }
                });
    	// vote
    	$.ajax(Routing.generate('becowo_core_vote', {name: document.getElementById('wsName').innerHTML}), {
    				data: $('#vote-form').serialize(),
                    type: "POST",
                    success: function(data) {
                    	$('#VoteResults').html("Merci, vote comptabilisé !");
                    },
                    error: function() {
                    	$('#VoteResults').html("Une erreur est survenue, veuillez réessayer plus tard");
                    }
                });
    		return false;


    });

});

// Page d'un WS, envoye le vote seul en AJAX
 /*   function goVote(){

    	$.ajax(Routing.generate('becowo_core_vote', {name: document.getElementById('wsName').innerHTML}), {
    				data: $('#vote-form').serialize(),
                    type: "POST",
                    success: function(data) {
                    	$('#VoteResults').html("Merci, vote comptabilisé !");
                    },
                    error: function() {
                    	$('#VoteResults').html("Une erreur est survenue, veuillez réessayer plus tard");
                    }
                });
    		return false;
    };
*/

/* Bouton Back to top */

    if ( ($(window).height() + 100) < $(document).height() ) {
    $('#top-link-block').removeClass('hidden').affix({
        // how far to scroll down before link "slides" into view
        offset: {top:100}
    });
    }

/* Cookie Consent plugin by Silktide - http://silktide.com/cookieconsent */
    window.cookieconsent_options = {"message":"En poursuivant votre navigation sur ce site, vous acceptez que des cookies soient utilisés.","dismiss":"J'ai compris !","learnMore":"En savoir plus","link":"https://www.microsoft.com/fr-fr/security/resources/cookie-whatis.aspx","theme":"light-floating"};

/*************** Vidéo on home page ****************
$(document).ready(function () 
    { 
        if (document.getElementById("video")){
            $('#video').videocontrols( 
            {  
                theme: 
                { 
                    progressbar: 'pink', 
                    range: 'pink', 
                    volume: 'pink' 
                },
                fillscreen: false,
                mediumscreen: false 
            }); 
        };
    }); 
*/
/************************ blackknight467/star-rating-bundle    rating.js *************************/

$(function(){
    var labelWasClicked = function labelWasClicked(){
        var input = $(this).siblings().filter('input');
        if (input.attr('disabled')) {
            return;
        }
        input.val($(this).attr('data-value'));
    }

    var turnToStar = function turnToStar(){
        if ($(this).find('input').attr('disabled')) {
            return;
        }
        var labels = $(this).find('div');
        labels.removeClass();
        labels.addClass('star');
    }

    var turnStarBack = function turnStarBack(){
        var rating = parseInt($(this).find('input').val());
        if (rating > 0) {
            var selectedStar = $(this).children().filter('#rating_star_'+rating)
            var prevLabels = $(selectedStar).nextAll();
            prevLabels.removeClass();
            prevLabels.addClass('star-full');
            selectedStar.removeClass();
            selectedStar.addClass('star-full');
        }
    }

    $('.star, .rating-well').click(labelWasClicked);
    $('.rating-well').each(turnStarBack);
    $('.rating-well').hover(turnToStar,turnStarBack);

});
/***************** fin rating.js ****************************/

/***************** Booking steps ****************************/
//http://www.jquery-steps.com/Examples#basic
/*
$("#booking-steps").steps({
    headerTag: "titre",
    bodyTag: "section",
    transitionEffect: "slideLeft",
    autoFocus: true,
    onStepChanging: function (event, currentIndex, newIndex)
    {
    	console.log(currentIndex);
    	console.log(newIndex);
    	
    	if(newIndex == 1) //Passage à l'étape paiement
    	{
	    	if(document.getElementById('booking-recap-price').innerHTML > 0)
	    	{
	    		document.getElementById('booking-error').innerHTML = "";
    			document.getElementById('barre-steps-0').style.borderColor = "var(--my-blue)";
    			document.getElementById('booking-steps-t-1').style.background = "var(--my-blue)";
	    		return true;
	    	}else{
	    		document.getElementById('booking-error').innerHTML = "Il manque un élément pour réserver";
	    		return false;
	    	}
	    }else if(newIndex == 2) // Passage à l'étape confirmation
	    {
	    		document.getElementById('barre-steps-1').style.borderColor = "var(--my-blue)";
    			document.getElementById('booking-steps-t-2').style.background = "var(--my-blue)";
	    }else if(newIndex == 3) // Finish
	    {
    			document.getElementById('booking-steps-t-3').style.background = "var(--my-blue)";
	    }

    }
});
*/

/***************** Booking calendar ****************************/
// http://www.daterangepicker.com

// Le calendrier s'adapte en fonction de la durée le location choisie
function loadCalendar(){

	var closedDates = document.getElementById('closedDates').innerHTML;
	closedDates = closedDates.replace(/(?:\r\n|\r|\n)/g, '');
	closedDates = closedDates.trim();
	var closedDatesTab = closedDates.split(',');

	if(document.querySelector('input[name="booking-duration"]:checked').value == 'Heure' || document.querySelector('input[name="booking-duration"]:checked').value == '1/2 journée' || document.querySelector('input[name="booking-duration"]:checked').value == 'Journée') {

		$('#booking-calendar').daterangepicker({
	        timePicker: false,
	        singleDatePicker: true,
	        locale: {
	            format: 'DD/MM/YYYY',
	            separator: '/',
	            applyLabel: 'Valider',
	            cancelLabel: 'Annuler',
	            daysOfWeek: ['Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa', 'Di'],
	            monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Aôut','Septembre','Octobre','Novembre','Décembre'],
	            firstDay: '2'
	        },
	        startDate: new Date(),
	        minDate: new Date(),
	        maxDate: new Date(new Date().setFullYear(new Date().getFullYear() + 1)), // 1 year
	    	isInvalidDate: function(date) {

	    		if ($.inArray(date.format('DD/MM/YYYY'), closedDatesTab) != -1) {
			        return true;
			    } else if(document.getElementById('isOpenSaturday').innerHTML != 1 && document.getElementById('isOpenSunday').innerHTML != 1){
			    	return (date.day() == 5 || date.day() == 6 || date < new Date() ); // disable saturday, sunday and past dates
	    		}else if(document.getElementById('isOpenSaturday').innerHTML == 1 && document.getElementById('isOpenSunday').innerHTML != 1){
	    			return (date.day() == 6 || date < new Date() );
	    		}else if(document.getElementById('isOpenSaturday').innerHTML != 1 && document.getElementById('isOpenSunday').innerHTML == 1){
	    			return (date.day() == 5 || date < new Date() );
	    		}else if(document.getElementById('isOpenSaturday').innerHTML == 1 && document.getElementById('isOpenSunday').innerHTML == 1){
	    			return (date < new Date() );
	    		}
			  }
	    });
	} else if (document.querySelector('input[name="booking-duration"]:checked').value == 'Semaine' || document.querySelector('input[name="booking-duration"]:checked').value == 'Mois'){
		$('#booking-calendar').daterangepicker({
	        timePicker: false,
	        singleDatePicker: false,
	        locale: {
	            format: 'DD/MM/YYYY',
	            separator: '/',
	            applyLabel: 'Valider',
	            cancelLabel: 'Annuler',
	            daysOfWeek: ['Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa', 'Di'],
	            monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Aôut','Septembre','Octobre','Novembre','Décembre'],
	            firstDay: '2'
	        },
	        startDate: new Date(),
	        minDate: new Date(),
	        maxDate: new Date(new Date().setFullYear(new Date().getFullYear() + 1)), // 1 year
	    	isInvalidDate: function(date) {

	    		if ($.inArray(date.format('DD/MM/YYYY'), closedDatesTab) != -1) {
			        return true;
			    } else if(document.getElementById('isOpenSaturday').innerHTML != 1 && document.getElementById('isOpenSunday').innerHTML != 1){
			    	return (date.day() == 5 || date.day() == 6 || date < new Date() ); // disable saturday, sunday and past dates
	    		}else if(document.getElementById('isOpenSaturday').innerHTML == 1 && document.getElementById('isOpenSunday').innerHTML != 1){
	    			return (date.day() == 6 || date < new Date() );
	    		}else if(document.getElementById('isOpenSaturday').innerHTML != 1 && document.getElementById('isOpenSunday').innerHTML == 1){
	    			return (date.day() == 5 || date < new Date() );
	    		}else if(document.getElementById('isOpenSaturday').innerHTML == 1 && document.getElementById('isOpenSunday').innerHTML == 1){
	    			return (date < new Date() );
	    		}
			  }
	    });


	    $('#booking-calendar').on('apply.daterangepicker', function (e, picker) {

	    	$(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));

	    	var end = new Date(picker.endDate);
	    	var begin = new Date(picker.startDate);
	    	// end = moment(end).add(1, 'm'); // Add 1 minute

	    	var diff = moment.preciseDiff(begin, end, true); // http://codebox.org.uk/pages/moment-date-range-plugin

			if (document.querySelector('input[name="booking-duration"]:checked').value == 'Semaine'){
		        
		        	document.getElementById('calendar-error').innerHTML = "TO DO vérifier saisie est en semaine";
					document.getElementById('booking-recap-date-calculated').innerHTML = "TO DO calculer le nb de semaines"
		    }else{
		    	if(diff.months > 0 && diff.days == 0){
		        	document.getElementById('calendar-error').innerHTML = "";
		        	document.getElementById('booking-recap-date-calculated').innerHTML = diff.months;
		        }
		        else{
		        	document.getElementById('calendar-error').innerHTML = "Pour profiter du tarif mois, veuillez sélectionner un mois complet.";
		        }
		    };

	    });

	}


	$('#booking-calendar').on('apply.daterangepicker', function(ev, picker) {
		if(picker.startDate.date() == picker.endDate.date()){
			document.getElementById('booking-recap-date').innerHTML = picker.startDate.format('DD/MM/YYYY');
		}else{
			$(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
			document.getElementById('booking-recap-date').innerHTML = "Du ";
			document.getElementById('booking-recap-date').innerHTML += picker.startDate.format('DD/MM/YYYY');
			document.getElementById('booking-recap-date').innerHTML += " Au ";
			document.getElementById('booking-recap-date').innerHTML += picker.endDate.format('DD/MM/YYYY');

		}
	});




	bookCalculatePrice();
};

/***************** Booking time ****************************/
// http://seiyria.com/bootstrap-slider/

function loadTime(boo){
	if(boo){ // true
		document.getElementById('calendar-time').style.display = 'block';
		var ouverture = document.getElementById('calendar-time-min').innerHTML.split(':');
		var ouvertureMinutes = Number(ouverture[0]) * 60 + Number(ouverture[1]);
		var fermeture = document.getElementById('calendar-time-max').innerHTML.split(':');
		var fermetureMinutes = Number(fermeture[0]) * 60 + Number(fermeture[1]);

		var mySliderTime = $("#booking-time-slider").slider({

		range: true,
    	min: ouvertureMinutes,	// every values are in minutes
    	max: fermetureMinutes,
    	step: 30,
    	value: [600, 720]

		});
		mySliderTime.on('change', function(ev){

		var valeurs = mySliderTime.data('slider').getValue();

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

		$('.slideTime .tooltip-inner').html(hours1 + ':' + minutes1 + ' - ' + hours2 + ':' + minutes2);
//		mySliderTime.data('slider').setValue(""); pour changer le tooltip black mais pb de format de value
		document.getElementById('booking-recap-time').innerHTML = 'De ' + hours1 + ':' + minutes1 + ' à ' + hours2 + ':' + minutes2;
		document.getElementById('booking-recap-time-calculated').innerHTML = (valeurs[1] - valeurs[0])/60;
		
		bookCalculatePrice();
		});

	}else{ // false
		document.getElementById('calendar-time').style.display = 'none';
	}

	bookCalculatePrice();
}

function loadHalfTime(boo){
	if(boo){
		document.getElementById('calendar-halftime').style.display = 'block';
	}else{
		document.getElementById('calendar-halftime').style.display = 'none';
	}

	bookCalculatePrice();
}
/***************** Booking people ****************************/
$( document ).ready(function() {
	var mySliderPeople = $("#booking-people").slider({});
	mySliderPeople.on('change', function(ev){
		document.getElementById('booking-recap-people').innerHTML = mySliderPeople.data('slider').getValue();
		document.getElementById('booking-recap-people-txt').innerHTML = " personne(s)"; 
		bookCalculatePrice();
	});
});

/***************** Booking offices ****************************/
function bookOffice() { 
	var off = document.querySelector('input[name="office"]:checked').value.split('*');
    document.getElementById('booking-recap-office').innerHTML = off[0];
    document.getElementById('booking-recap-office-type').innerHTML = off[1];
    // Change la valeur max du slider de personnes, en fonction du 'deskQty' de l'office sélectionné
    $("#booking-people").slider('setAttribute', 'max', document.getElementById('SelectedOffice-' + document.querySelector('input[name="office"]:checked').value + '-deskQty').innerHTML);
    $("#booking-people").slider('refresh');
    document.getElementById('booking-people-max').innerHTML = document.getElementById('SelectedOffice-' + document.querySelector('input[name="office"]:checked').value + '-deskQty').innerHTML;
    bookCalculatePrice();
};

/***************** Booking duration choices ****************************/
function chooseDuration() {
	//Récup la liste des bureaux
	var oInput = document.getElementById('booking-office'),
            oChild;
    for(i = 0; i < oInput.childNodes.length; i++){
        oChild = oInput.childNodes[i];
        if(oChild.nodeName == 'INPUT'){ // Boucle sur chaque input dont l'ID est un type d'espace
        	// Inscrit le prix par durée sélectionnée, pour chaque bureau
	        var p = document.getElementById('SelectedOffice-' + oChild.id + '-price' + document.querySelector('input[name="booking-duration"]:checked').value).innerHTML;
			document.getElementById('pricePerOffice-' + oChild.id).innerHTML = p;
        	

        	// si un prix est à zéro on cache le choix du bureau car ca veut dire qu'il n'est pas réservable pour cette durée de tps
        	if(p == 0)
        	{
				$('label[for="' + oChild.id + '"]').hide();
        	} else
        	{
        		$('label[for="' + oChild.id + '"]').show();

	        	switch(document.querySelector('input[name="booking-duration"]:checked').value) {
	        		case 'Heure':
	        			document.getElementById('pricePerOffice-' + oChild.id).innerHTML += ' € / heure*';
	        			loadTime(true);
	        			loadHalfTime(false);
	        			break;
	        		case '1/2 journée':
	        			document.getElementById('pricePerOffice-' + oChild.id).innerHTML += ' € / 1/2 journée*';
	        			loadTime(false);
	        			loadHalfTime(true);
	        			break;
	        		case 'Journée':
	        			document.getElementById('pricePerOffice-' + oChild.id).innerHTML += ' € / jour*';
	        			loadTime(false);
	        			loadHalfTime(false);
	        			break;
	        		case 'Semaine':
	        			document.getElementById('pricePerOffice-' + oChild.id).innerHTML += ' € / Semaine*';
	        			loadTime(false);
	        			loadHalfTime(false);
	        			break;
	        		case 'Mois':
	        			document.getElementById('pricePerOffice-' + oChild.id).innerHTML += ' € / Mois*';
	        			loadTime(false);
	        			loadHalfTime(false);
	        			break;
	        		default:
	        			document.getElementById('pricePerOffice-' + oChild.id).innerHTML += ' €*';
	        			loadTime(false);
	        			loadHalfTime(false);
	        	}
        	}
        }
    }
    document.getElementById('booking-recap-duration').innerHTML = document.querySelector('input[name="booking-duration"]:checked').value;

    loadCalendar();
    bookCalculatePrice();

}
$( document ).ready(function() {
	//Affichage des prix au démarrage
    chooseDuration();
});

/************************* Booking calculate price *******************/

function bookCalculatePrice()
{
	// SelectedOffice-{{office.office.name}}-priceHeure

	var officeReserved = document.getElementById('booking-recap-office').innerHTML;
	var officeTypeReserved = document.getElementById('booking-recap-office-type').innerHTML;
	var dateReserved = document.getElementById('booking-recap-date').innerHTML;
	var dateCalculatedReserved = document.getElementById('booking-recap-date-calculated').innerHTML;
	var durationReserved = document.getElementById('booking-recap-duration').innerHTML;
	var timeReserved = document.getElementById('booking-recap-time').innerHTML;
	var timeCalculatedReserved = document.getElementById('booking-recap-time-calculated').innerHTML;
	var peopleReserved = document.getElementById('booking-recap-people').innerHTML;
	var pricePerOffice = 0;
	console.log('**********************');
	console.log('SelectedOffice-' + officeReserved + '*' + officeTypeReserved + '-price' + durationReserved);
	if(document.getElementById('SelectedOffice-' + officeReserved + '*' + officeTypeReserved + '-price' + durationReserved) != null)
	{
		pricePerOffice = Number(document.getElementById('SelectedOffice-' + officeReserved + '*' + officeTypeReserved + '-price' + durationReserved).innerHTML);
	}else{
		pricePerOffice = 0;
	}
	var finalPrice = 0;


	if(officeTypeReserved == 'Open space')
	{
		// le prix est par personne (sinon il est par bureau)
		pricePerOffice = pricePerOffice * peopleReserved;
	}

	// A la 1/2 journée et journée, pas besoin de multipler le prix car un seul 'espace temps' réservable
	if(durationReserved == 'Heure')
	{
		finalPrice = pricePerOffice * timeCalculatedReserved;
	}else if(durationReserved == 'Semaine')
	{
		// TO DO calculer le nb de semaine sélectionnée
	}else if(durationReserved == 'Mois')
	{
		finalPrice = pricePerOffice * dateCalculatedReserved;
	}else
	{
		finalPrice = pricePerOffice;
	}


	document.getElementById('booking-recap-price').innerHTML = finalPrice;
	document.getElementById('booking-recap-price-txt').innerHTML = " € TTC";
	document.getElementById('booking-price-incl-tax').value = finalPrice;
}

/*************duration day choice ************************/

function chooseDurationDay()
{
	document.getElementById('booking-recap-duration-txt').innerHTML = document.querySelector('input[name="booking-duration-day"]:checked').value;
}
	