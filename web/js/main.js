// Google Analytics DEMO
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-77791149-2', 'auto');
  ga('send', 'pageview');

// End Google Analytics 

// Gestion de la class active sur la navbar
$(document).ready(function () {
    var url = window.location;
    // Will only work if string in href matches with location
    $('ul.nav a[href="' + url + '"]').parent().addClass('active');

    // Will also work for relative and absolute hrefs
    $('ul.nav a').filter(function () {
        return this.href == url;
    }).parent().addClass('active').parent().parent().addClass('active');
});

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

// Page d'un WS, envoye le booking en AJAX
$(function () {
    $("#btn_confirm").unbind("click").click(function(){
    	$.ajax(Routing.generate('becowo_core_booking', {name: document.getElementById('wsName').innerHTML}), {
            data: $('#booking-form').serialize(),
            type: "POST",
            success: function(data) {
                $('#modal-body').html(data);
                $('#modal-footer').html('');
            },
            error: function() {
            	$('#modal-body').html("Une erreur est survenue, veuillez réessayer plus tard");
                $('#modal-footer').html('');
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

// Smooth scrolling for home button
$("#goToMap").unbind("click").click(function(e){
		e.preventDefault();
		$('html, body').animate({ scrollTop: $($(this).attr('href')).offset().top}, 1000, 'linear');
});

//Navbar Scroll Event
var navbar = $('.navbar');
$(window).scroll(function(event){
   var st = $(this).scrollTop();
   if (st > 70){
       navbar.addClass('navbar-scroll-custom');
   } 
   if(st < 150) {
      navbar.removeClass('navbar-scroll-custom');
   }
});

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

// Le calendrier s'adapte en fonction de la durée de location choisie
function loadCalendar(id, duree, prix){

	var closedDates = document.getElementById('closedDates').innerHTML;
	closedDates = closedDates.replace(/(?:\r\n|\r|\n)/g, '');
	closedDates = closedDates.trim();
	var closedDatesTab = closedDates.split(',');

	if(duree == 'Heure' || duree == '1/2 journée' || duree == 'Journée') {
 
		$('#booking-calendar-' + id).daterangepicker({
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
	} else if (duree == 'Semaine' || duree == 'Mois'){
		$('#booking-calendar-' + id).daterangepicker({
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


	    $('#booking-calendar-' + id).on('apply.daterangepicker', function (e, picker) {

	    	$(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));

	    	var end = new Date(picker.endDate);
	    	var begin = new Date(picker.startDate);
	    	// end = moment(end).add(1, 'm'); // Add 1 minute

	    	var diff = moment.preciseDiff(begin, end, true); // http://codebox.org.uk/pages/moment-date-range-plugin

			if (duree == 'Semaine'){
		        
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


	// $('#booking-calendar-' + id).on('apply.daterangepicker', function(ev, picker) {
	// 	if(picker.startDate.date() == picker.endDate.date()){
	// 		document.getElementById('booking-recap-date').innerHTML = picker.startDate.format('DD/MM/YYYY');
	// 	}else{
	// 		$(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
	// 		document.getElementById('booking-recap-date').innerHTML = "Du ";
	// 		document.getElementById('booking-recap-date').innerHTML += picker.startDate.format('DD/MM/YYYY');
	// 		document.getElementById('booking-recap-date').innerHTML += " Au ";
	// 		document.getElementById('booking-recap-date').innerHTML += picker.endDate.format('DD/MM/YYYY');

	// 	}
	// });

	loadTime(id, duree, prix);
	loadPeople(id, duree, prix);
	loadPrice(id, duree, prix); 
//	bookCalculatePrice();
};

/***************** Booking time ****************************/
// http://seiyria.com/bootstrap-slider/

function loadTime(id, duree, prix){
	if(duree == 'Heure'){ 
		document.getElementById('calendar-halftime-' + id).style.display = 'none';
		document.getElementById('calendar-time-' + id).style.display = 'block';
		var ouverture = document.getElementById('calendar-time-min').innerHTML.split(':');
		var ouvertureMinutes = Number(ouverture[0]) * 60 + Number(ouverture[1]);
		var fermeture = document.getElementById('calendar-time-max').innerHTML.split(':');
		var fermetureMinutes = Number(fermeture[0]) * 60 + Number(fermeture[1]);

		var mySliderTime = $("#booking-time-slider-" + id).slider({
		range: true,
    	min: ouvertureMinutes,	// every values are in minutes
    	max: fermetureMinutes,
    	step: 30,
    	value: [ouvertureMinutes, ouvertureMinutes+60]

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
	
	//	document.getElementById('booking-recap-time').innerHTML = 'De ' + hours1 + ':' + minutes1 + ' à ' + hours2 + ':' + minutes2;
	//	document.getElementById('booking-recap-time-calculated').innerHTML = (valeurs[1] - valeurs[0])/60;
		var nbHeures = (valeurs[1] - valeurs[0])/60;
		document.getElementById('recap-nbHeures-' + id).innerHTML = nbHeures;

		loadPrice(id, duree, prix);
	//	bookCalculatePrice();
		});

	}else if(duree == '1/2 journée'){ 
		document.getElementById('calendar-time-' + id).style.display = 'none';
		document.getElementById('calendar-halftime-' + id).style.display = 'block';
	}else{
		document.getElementById('calendar-time-' + id).style.display = 'none';
		document.getElementById('calendar-halftime-' + id).style.display = 'none';
	}

	loadPrice(id, duree, prix);
//	bookCalculatePrice();
}

// function loadHalfTime(boo){
// 	if(boo){
// 		document.getElementById('calendar-halftime').style.display = 'block';
// 	}else{
// 		document.getElementById('calendar-halftime').style.display = 'none';
// 	}

// 	bookCalculatePrice();
// }
/***************** Booking people ****************************/
function loadPeople(id, duree, prix, nbHeures) {
	var mySliderPeople = $("#booking-people-" + id).slider({});
	if(mySliderPeople != null)
	{
	mySliderPeople.on('change', function(ev){
		// document.getElementById('booking-recap-people').innerHTML = mySliderPeople.data('slider').getValue();
		// document.getElementById('booking-recap-people-txt').innerHTML = " personne(s)"; 
		// bookCalculatePrice();
		var nbPeople = mySliderPeople.data('slider').getValue();
		document.getElementById('recap-nbPeople-' + id).innerHTML = nbPeople;

		loadPrice(id, duree, prix);
	});
	}
};

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
    if(oInput != null)
    {

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

 //   loadCalendar();
    bookCalculatePrice();
    
    }

}
$( document ).ready(function() {
	//Affichage des prix au démarrage
    chooseDuration();
});
/************************* Booking calculate price 2 *******************/
function loadPrice(id, duree, prix){

	var total = prix;
	var officeType = document.getElementById('recap-officeType-' + id).innerHTML;
	var nbHeures = document.getElementById('recap-nbHeures-' + id).innerHTML;
	var nbPeople = document.getElementById('recap-nbPeople-' + id).innerHTML;


	if(duree == 'Heure'){
		total = prix * nbHeures;
	}else{
		total = prix;
	}

	if(officeType == 'Open space'){
		total = total * nbPeople;
	}


	document.getElementById('booking-recap-price-'+id).innerHTML = total;
	document.getElementById('booking-price-excl-tax-'+id).value = total;

}


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



// Le calendrier s'adapte en fonction de la durée de location choisie
function loadCalendar2(duree){

	var closedDates = document.getElementById('closedDates').innerHTML;
	closedDates = closedDates.replace(/(?:\r\n|\r|\n)/g, '');
	closedDates = closedDates.trim();
	var closedDatesTab = closedDates.split(',');

	if(duree == 'heure' || duree == 'demijournee' || duree == 'journee') {
 
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
	} else if (duree == 'semaine' || duree == 'mois'){
		var cal = $('#booking-calendar').daterangepicker({
	        timePicker: false,
	        singleDatePicker: false,
	        autoApply: true, // Pas de buton valider/Annuler
	        locale: {
	            format: 'DD/MM/YYYY',
	            separator: '/',
	            //applyLabel: 'Valider',
	            //cancelLabel: 'Annuler',
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

			if (duree == 'semaine'){
		        	document.getElementById('calendar-error').innerHTML = "TO DO vérifier saisie est en semaine";
		    }else{
		    	if(diff.months > 0 && diff.days == 0){
		        	document.getElementById('calendar-error').innerHTML = "";
		        }
		        else{
		        	document.getElementById('calendar-error').innerHTML = "Pour profiter du tarif mois, veuillez sélectionner un mois complet.";
		        }
		    };

	    });

	}
};

/********************************  JS construction form dans modal ******************/

$('#myModalResaTest').on('show.bs.modal', function(e) {
  var modalData = e.relatedTarget.dataset;
console.log(modalData);

  // attention tout en minuscule pour lire le contenu de modalData
  document.getElementById('spaceName').innerHTML = modalData['spacename'];
  document.getElementById('capacity').innerHTML = modalData['capacity'];
  document.getElementById('wshasofficeID').value = modalData['wshasofficeid'];

  	// CONSTRUCTION DURATION
  	var listeDuration = ['heure', 'demijournee', 'journee', 'semaine', 'mois']; // doit être en minuscule
//  	var listeDurationEN = ['hour', 'halfday', 'day', 'week', 'month']; // doit être en minuscule
  	var premier = true;
  	var maDiv = document.getElementById('booking-duration');
  	for (j=0 ; j < listeDuration.length ; j++)
  	{
  		//On ne rajoute la valeur que s'il y a un prix
  		if(modalData['price' + listeDuration[j]] != "")
  		{
	  		var i = document.createElement('input');
			i.setAttribute("type", "radio");
			i.setAttribute("name", "booking-duration");
			i.setAttribute("id", "booking-duration-" + listeDuration[j]);
			i.setAttribute("value", listeDuration[j]);

			// on sélectionne le premier choix
			if(premier)
			{
				i.setAttribute("checked", "true");
				premier = false;
			};

			maDiv.appendChild(i);
		}
  	};
  	//on est obligé de charger tous les input et ensuite tous les label
  	for (j=0 ; j < listeDuration.length ; j++)
  	{
  		//On ne rajoute la valeur que s'il y a un prix
  		if(modalData['price' + listeDuration[j]] != "")
  		{
			var l = document.createElement('label');
			l.setAttribute("for", "booking-duration-" + listeDuration[j]);
			l.setAttribute("data-value",listeDuration[j]);
			l.innerHTML = listeDuration[j];

			maDiv.appendChild(l);
		}
  	};

  	if(maDiv.getElementsByTagName('label').length == 1){
  		maDiv.getElementsByTagName('label')[0].style.opacity = '0'; // on désactive le label s'il n'y en a qu'un seul
  		maDiv.getElementsByTagName('label')[0].style.height = '0';
  	}else{
  		document.getElementById('booking-duration').style.width="500px";
  		document.getElementById('booking-duration').style.border="solid";
  		document.getElementById('booking-duration').style.textTransform="uppercase";
  	}
  
  // CONSTRUCTION DATE
  document.getElementById('isOpenSaturday').innerHTML = modalData['isopensaturday'];
  document.getElementById('isOpenSunday').innerHTML = modalData['isopensunday'];
  document.getElementById('closedDates').innerHTML = ""; // TO DO remplir les dates de fermeture
  // En twig : <div id="closedDates" style="display:none">
// 	{% for d in closedDates %}{{- d.closedDate.date|date("d/m/Y") -}},{% endfor %}
// </div>

	// CONSTRUCTION CALENDAR
	var duree = document.querySelector('input[name="booking-duration"]:checked').value;
	loadCalendar3(duree, modalData);

	// CONSTRUCTION HORAIRE
	loadTime2(duree, modalData);

	// CONSTRUCTION PEOPLE
	var mySliderPeople = $("#booking-people").slider({
		max: modalData['capacity']
	});
	document.getElementById('booking-people-max').innerHTML = modalData['capacity'];
	mySliderPeople.on('change', function(ev){
		var nbPeople = mySliderPeople.data('slider').getValue();
		document.getElementById('nbPeople').innerHTML = nbPeople;

		loadPrice2(duree, modalData);
	});

	// On reload des éléments à chaque fois que la duration change :
	$('#booking-duration').on('change', function() { 
	    var duree = document.querySelector('input[name="booking-duration"]:checked').value;
	    // reset calendar
		$('#booking-calendar').data('dateRangePicker').destroy();
	    loadCalendar3(duree, modalData);
	    loadTime2(duree, modalData);
	    loadPrice2(duree, modalData);
	});


});

// on reset le formulaire quand la modal se ferme
$('#myModalResaTest').on('hidden.bs.modal', function (e) {
  	var element = document.getElementById("booking-duration");
	while (element.firstChild) {
  		element.removeChild(element.firstChild);
	}
	// reset calendar
	$('#booking-calendar').data('dateRangePicker').destroy();
})



// config : http://longbill.github.io/jquery-date-range-picker/
function loadCalendar3(duree, modalData)
{
	var closedDates = document.getElementById('closedDates').innerHTML;
	closedDates = closedDates.replace(/(?:\r\n|\r|\n)/g, '');
	closedDates = closedDates.trim();
	var closedDatesTab = closedDates.split(',');

	if(duree == 'heure' || duree == 'demijournee' || duree == 'journee') {

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
			loadPrice2(duree, modalData);
		});

	}else if (duree == 'semaine'){

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
			loadPrice2(duree, modalData);
		});

	}else if (duree == 'mois'){

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
			loadPrice2(duree, modalData);
		});

	};


	// TO DO
	// Désactiver samedi / dimanche selon BDD
	// Désactiver jours fermés
}

function loadTime2(duree, modalData){

	if(duree == 'heure'){ 
		document.getElementById('calendar-halftime').style.display = 'none';
		document.getElementById('calendar-time').style.display = 'block';
		document.getElementById('time-min').innerHTML = modalData['openhour'].replace(':', 'h');
		document.getElementById('time-max').innerHTML = modalData['closehour'].replace(':', 'h');

		var ouverture = modalData['openhour'].split(':');
		var ouvertureMinutes = Number(ouverture[0]) * 60 + Number(ouverture[1]);
		var fermeture = modalData['closehour'].split(':');
		var fermetureMinutes = Number(fermeture[0]) * 60 + Number(fermeture[1]);

		var mySliderTime = $("#booking-time-slider").slider({
		range: true,
    	min: ouvertureMinutes,	// every values are in minutes
    	max: fermetureMinutes,
    	step: 60,
    	value: [ouvertureMinutes, ouvertureMinutes+60]

		});

		mySliderTime.on('slide', function(ev){

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
	
		var nbHeures = (valeurs[1] - valeurs[0])/60;
		document.getElementById('nbHeures').innerHTML = nbHeures;

		loadPrice2(duree, modalData);
		});


		//on désactive les tooltip car le txt affiché ne convient pas
		document.getElementsByClassName('tooltip-main')[0].style.display = 'none';
		document.getElementsByClassName('tooltip-inner')[0].style.display = 'none';
		document.getElementsByClassName('tooltip-arrow')[0].style.display = 'none';
		loadPrice2(duree, modalData);

	}else if(duree == 'demijournee'){ 
		document.getElementById('calendar-time').style.display = 'none';
		document.getElementById('calendar-halftime').style.display = 'block';
	}else{
		document.getElementById('calendar-time').style.display = 'none';
		document.getElementById('calendar-halftime').style.display = 'none';
	}

}

function loadPrice2(duree, modalData){

	var prix = modalData['price' + duree]; 
	var total = prix;
	var officeType = modalData['spacetype'];
	var nbHeures = document.getElementById('nbHeures').innerHTML;
	var nbPeople = document.getElementById('nbPeople').innerHTML;

	if(duree == 'heure'){
		total = prix * nbHeures;
	}else{
		total = prix;
	}

	if(officeType == 'Open space'){
		total = total * nbPeople;
	}

	document.getElementById('price-excl-tax').value = total;
	document.getElementById('price-incl-tax').value = total * (1 + modalData['tva']/100);

}
