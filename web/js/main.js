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

$("#booking-steps").steps({
    headerTag: "titre",
    bodyTag: "section",
    transitionEffect: "slideLeft",
    autoFocus: true
});


/***************** Booking calendar ****************************/
// http://www.daterangepicker.com

// Le calendrier s'adapte en fonction de la durée le location choisie
function loadCalendar(){
	if(document.querySelector('input[name="booking-duration"]:checked').value == 'Heure' || document.querySelector('input[name="booking-duration"]:checked').value == '1/2 journée' || document.querySelector('input[name="booking-duration"]:checked').value == 'Journée') {
		console.log('calendrier heure');
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
			    return (date.day() == 5 || date.day() == 6 || date < new Date() ); // disable saturday, sunday and past dates
			  }
	    });
	} else if (document.querySelector('input[name="booking-duration"]:checked').value == 'Semaine' || document.querySelector('input[name="booking-duration"]:checked').value == 'Mois'){
		console.log('calendrier semaine');
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
			    return (date.day() == 5 || date.day() == 6 || date < new Date() ); // disable saturday, sunday and past dates
			  }
	    });


	    $('#booking-calendar').on('apply.daterangepicker', function (e, picker) {
	    	var end = new Date(picker.endDate);
	    	var begin = new Date(picker.startDate);
	    	var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds

			var diffDays = Math.round(Math.abs((end.getTime() - begin.getTime())/(oneDay)));
	        if(diffDays % 5 != 0){
	        	document.getElementById('calendar-error').innerHTML = "Pour profiter du tarif semaine, veuillez sélectionner une semaine complète ";
	        }
	        else{
	        	document.getElementById('calendar-error').innerHTML = "";
	        }
	    });
	}
};


$('#booking-calendar').on('apply.daterangepicker', function(ev, picker) {
	document.getElementById('booking-recap-date').innerHTML = "Du ";
	document.getElementById('booking-recap-date').innerHTML += picker.startDate.format('DD/MM/YYYY');
	document.getElementById('booking-recap-date').innerHTML += " Au ";
	document.getElementById('booking-recap-date').innerHTML += picker.endDate.format('DD/MM/YYYY');
});
/***************** Booking slider ****************************/
// http://seiyria.com/bootstrap-slider/
var mySliderTime = $("#booking-time-slider").slider({});
mySliderTime.on('change', function(ev){
	document.getElementById('booking-recap-time').innerHTML = mySliderTime.data('slider').getValue();
});

var mySliderPeople = $("#booking-slider").slider({});
mySliderPeople.on('change', function(ev){
	document.getElementById('booking-recap-people').innerHTML = mySliderPeople.data('slider').getValue();
	document.getElementById('booking-recap-people').innerHTML += " personne(s)"; 
});

/***************** Booking offices ****************************/
function bookOffice() { 
    document.getElementById('booking-recap-office').innerHTML = document.querySelector('input[name="office"]:checked').value;
    // Change la valeur max du slider de personnes, en fonction du 'deskQty' de l'office sélectionné
    $("#booking-slider").slider('setAttribute', 'max', document.getElementById('SelectedOffice-' + document.querySelector('input[name="office"]:checked').value + '-deskQty').innerHTML);
    $("#booking-slider").slider('refresh');
    document.getElementById('booking-slider-max').innerHTML = document.getElementById('SelectedOffice-' + document.querySelector('input[name="office"]:checked').value + '-deskQty').innerHTML;
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
        	document.getElementById('pricePerOffice-' + oChild.id).innerHTML = document.getElementById('SelectedOffice-' + oChild.id + '-price' + document.querySelector('input[name="booking-duration"]:checked').value).innerHTML;
        	switch(document.querySelector('input[name="booking-duration"]:checked').value) {
        		case 'Heure':
        			document.getElementById('pricePerOffice-' + oChild.id).innerHTML += '€ / heure';
        			break;
        		case '1/2 journée':
        			document.getElementById('pricePerOffice-' + oChild.id).innerHTML += '€ / 1/2 journée';
        			break;
        		case 'Journée':
        			document.getElementById('pricePerOffice-' + oChild.id).innerHTML += '€ / jour';
        			break;
        		case 'Semaine':
        			document.getElementById('pricePerOffice-' + oChild.id).innerHTML += '€ / Semaine';
        			break;
        		case 'Mois':
        			document.getElementById('pricePerOffice-' + oChild.id).innerHTML += '€ / Mois';
        			break;
        		default:
        			document.getElementById('pricePerOffice-' + oChild.id).innerHTML += '€';
        	}
        }
    }
    document.getElementById('booking-recap-duration').innerHTML = document.querySelector('input[name="booking-duration"]:checked').value;

    loadCalendar();
}
$( document ).ready(function() {
	//Affichage des prix au démarrage
    chooseDuration();
});
