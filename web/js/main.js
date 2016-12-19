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

// Page d'un WS, envoye le formulaire de contact manager en AJAX
$(function () {
    $("#submitContactManager").unbind("click").click(function(){
        console.log('ajax contact');
        // $('#myModalManagerContact').modal({});
        $.ajax(Routing.generate('becowo_core_workspace_contact', {name: document.getElementById('wsName').innerHTML}), {
            data: $('#contact-form').serialize(),
            type: "POST",
            success: function(data) {
                $('#modal-body').html(data);
            },
            error: function() {
                $('#modal-body').html("Une erreur est survenue, veuillez réessayer plus tard");
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

// Gestion des URL distincits pour chaque onglet dans page d'un WS
$(function(){
var hash = window.location.hash;
if(hash != '')
{
	hash = hash.substring(1, hash.length);
	console.log(hash);
	var e = document.getElementById(hash);
	e.classList.add("active");
	e.classList.add("in");
}
else{
	$('.nav-tabs a[href="#Description"]').tab('show')
	var e = document.getElementById('Description');
	if(e){
		e.classList.add("active");
		e.classList.add("in");
	};
	
}

// Qd clic sur un onglet, Change URL et onglet + décale de 33px l'ancre 
$('.nav-tabs a').on('shown.bs.tab', function(event){                 
    window.location.hash = $(event.target).text();
    $('html, body').animate({scrollTop: $(event.target).offset().top - 33}, 0);
});

});

$('[id^="goToResa-"]').click(function() {
  $('#myTab a[href="#Réserver"]').tab('show');
});

/*********** Vidéo big size *********/
$(document).ready(function ()    
{if(document.getElementById("video-big") != null){
   
var video = document.getElementById("video-big");
var playButton = document.getElementById("play");
var pauseButton = document.getElementById("pause");
var fullScreenButton = document.getElementById("expand");
var fond = document.getElementById('fond');

function clickVideo(){
    if(video.paused)
        {
            video.play();
            playButton.style.display = "none";
            pauseButton.style.display = "none";
            video.style.opacity = 1;
            fond.style.display = "none";
        }else{
            video.pause();
            playButton.style.display = "inline-flex";
            pauseButton.style.display = "none";
            video.style.opacity = 0.5;
        } 
};

video.addEventListener("click", function(){clickVideo()});
playButton.addEventListener("click", function(){clickVideo()});
pauseButton.addEventListener("click", function(){clickVideo()});
fond.addEventListener("click", function(){clickVideo()});

function over(){
    if(video.paused == false)
    {
        pauseButton.style.display = "inline-flex";
    }
}

video.addEventListener("mouseover", function() {over()});
pauseButton.addEventListener("mouseover", function() {over()});

function out(){
    if(video.paused == false)
    {
        pauseButton.style.display = "none";
    }
}

video.addEventListener("mouseout", function() {out()});
pauseButton.addEventListener("mouseout", function() {out()});

fullScreenButton.addEventListener("click", function() {
  if (video.requestFullscreen) {
    video.requestFullscreen();
  } else if (video.mozRequestFullScreen) {
    video.mozRequestFullScreen(); // Firefox
  } else if (video.webkitRequestFullscreen) {
    video.webkitRequestFullscreen(); // Chrome and Safari
  }
});
};
});

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



/********************************  JS construction form dans modal de réservation ******************/


$('#myModalResa').on('show.bs.modal', function(e) {
  var modalData = e.relatedTarget.dataset;
// console.log(modalData);

  // attention tout en minuscule pour lire le contenu de modalData
  document.getElementById('spaceName').innerHTML = modalData['spacename'];

  if(modalData['spacetype'] == 'Open space'){
    document.getElementById('capacity').innerHTML = 'Quantité : ' + modalData['capacity'] + ' <i class="fa fa-briefcase" aria-hidden="true"></i>';
  }else{
    document.getElementById('capacity').innerHTML = 'Capacité : ' + modalData['capacity'] + ' <i class="fa fa-male" aria-hidden="true"></i>';
  }
  document.getElementById('wshasofficeID').value = modalData['wshasofficeid'];

  	// CONSTRUCTION DURATION
  	var listeDuration = ['heure', 'demijournee', 'journee', 'semaine', 'mois']; // doit être en minuscule
    var listeDurationAffichee = ['Heure', 'Demi-journée', 'Journée', 'Semaine', 'Mois'];
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
  	//on est obligé de charger tous les input et ensuite tous les labels
  	for (j=0 ; j < listeDuration.length ; j++)
  	{
  		//On ne rajoute la valeur que s'il y a un prix
  		if(modalData['price' + listeDuration[j]] != "")
  		{
			var l = document.createElement('label');
			l.setAttribute("for", "booking-duration-" + listeDuration[j]);
			l.setAttribute("data-value",listeDurationAffichee[j]);
			l.innerHTML = listeDurationAffichee[j];

			maDiv.appendChild(l);
		}
  	};

  	if(maDiv.getElementsByTagName('label').length == 1){
  		maDiv.getElementsByTagName('label')[0].style.opacity = '0'; // on désactive le label s'il n'y en a qu'un seul
  		maDiv.getElementsByTagName('label')[0].style.height = '0';
  	}else{
  		document.getElementById('booking-duration').style.width="500px";
  		document.getElementById('booking-duration').style.border="solid";
        maDiv.style.display = "block"; // on force l'affichage s'il a été caché on fermant une précédante modale
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
	loadCalendar(duree, modalData);

	// CONSTRUCTION HORAIRE
    // http://seiyria.com/bootstrap-slider/
	loadTime(duree, modalData);

	// CONSTRUCTION PEOPLE
	var mySliderPeople = $("#booking-people").slider({
		max: modalData['capacity']
	});
	document.getElementById('booking-people-max').innerHTML = modalData['capacity'];
    if(modalData['spacetype'] == 'Open space'){
        document.getElementById('nbPeople-text').innerHTML = 'Nombre de coworkers : ';
    }else{
        document.getElementById('nbPeople-text').innerHTML = 'Nombre de coworkers (à titre indicatif) : ';
    }
	mySliderPeople.on('change', function(ev){
		var nbPeople = mySliderPeople.data('slider').getValue();
		document.getElementById('nbPeople').innerHTML = nbPeople;
        //On rafraichit la durée sélectionnée
        duree = document.querySelector('input[name="booking-duration"]:checked').value;
		loadPrice(duree, modalData);
	});

    // Prix par défaut
    loadPrice(duree, modalData);

	// On reload des éléments à chaque fois que la duration change :
	$('#booking-duration').on('change', function() { 
	    var duree = document.querySelector('input[name="booking-duration"]:checked').value;
	    // reset calendar
		$('#booking-calendar').data('dateRangePicker').destroy();
	    loadCalendar(duree, modalData);
	    loadTime(duree, modalData);
	    loadPrice(duree, modalData);
	});

    // On désactive le bouton 'confirmer' tant que le mois n'est pas sélectionné (pour tous les autres champs il y a une valeur par défaut)
    if(duree == 'mois')
    {
        document.getElementById('btn_confirm').disabled = true;
    }

});



// on reset le formulaire quand la modal se ferme
$('#myModalResa').on('hidden.bs.modal', function (e) {
  	var element = document.getElementById("booking-duration");
    if(element != null){
    	while (element.firstChild) {
      		element.removeChild(element.firstChild);
    	}
        element.style.display = "none";
    }
	// reset calendar
	$('#booking-calendar').data('dateRangePicker').destroy();
    //reset slider time
    $("#booking-time-slider").slider().data('slider').destroy();

 
})



// config : http://longbill.github.io/jquery-date-range-picker/
function loadCalendar(duree, modalData)
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
			loadPrice(duree, modalData);
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
			loadPrice(duree, modalData);
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
			loadPrice(duree, modalData);
            document.getElementById('btn_confirm').disabled = false;
		});

	};


	// TO DO
	// Désactiver samedi / dimanche selon BDD
	// Désactiver jours fermés
}

function loadTime(duree, modalData){

    // on doit reset le slider à chaque fois sinon ca bug
    $("#booking-time-slider").slider().data('slider').destroy();

	if(duree == 'heure'){ 
		document.getElementById('calendar-halftime').style.display = 'none';
		document.getElementById('calendar-time').style.display = 'block';

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

    		loadPrice(duree, modalData);
		});


		//on désactive les tooltip car le txt affiché ne convient pas
		document.getElementsByClassName('tooltip-main')[0].style.display = 'none';
		document.getElementsByClassName('tooltip-inner')[0].style.display = 'none';
		document.getElementsByClassName('tooltip-arrow')[0].style.display = 'none';
		loadPrice(duree, modalData);

	}else if(duree == 'demijournee'){ 
		document.getElementById('calendar-time').style.display = 'none';
		document.getElementById('calendar-halftime').style.display = 'block';
	}else{
		document.getElementById('calendar-time').style.display = 'none';
		document.getElementById('calendar-halftime').style.display = 'none';
	}

}

function loadPrice(duree, modalData){

	var prix = modalData['price' + duree]; 

    console.log(duree);
    console.log(prix);
    console.log(modalData);
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
    document.getElementById('price-excl-tax-div').innerHTML = total;
    document.getElementById('price-incl-tax-div').innerHTML = total * (1 + modalData['tva']/100);

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


