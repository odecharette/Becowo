// Google Analytics DEMO
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-77791149-2', 'auto');
  ga('send', 'pageview');

// End Google Analytics 

/* Cookie Consent plugin by Silktide - http://silktide.com/cookieconsent */
    window.cookieconsent_options = {"message":"En poursuivant votre navigation sur ce site, vous acceptez que des cookies soient utilisés.","dismiss":"J'ai compris !","learnMore":"En savoir plus","link":"https://www.microsoft.com/fr-fr/security/resources/cookie-whatis.aspx","theme":"light-floating"};

// Plugin FB like 

(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.8&appId=810073549123890";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

/****************** Page d'un WS, onglet réservation, filtre les bureaux ****************/

$('#filtre-bureaux').on('change', function() { 
  var text = document.querySelector('input[name="filtre-bureaux"]:checked').value;
    $('ul.listed-values li').hide();
    $('ul.listed-values li').filter(function(){
       return $(this).attr('class').indexOf(text) != -1;
    }).show();
});

// Home page viewMore button
$('#viewMore').bind('click', function (e) {
  var elements = document.getElementsByClassName("list-item");
console.log($('#viewMore').text());

  if($('#viewMore').text() == 'Voir plus'){

    for(var i=0; i<elements.length; i++) {
      elements[i].style.display = 'inline-block';
    }
    $('#viewMore').text('Voir moins');
  }else{
    for(var i=6; i<elements.length; i++) {
      elements[i].style.display = 'none';
    }
    $('#viewMore').text('Voir plus');
  }

});

console.log('width de l\'écran : ' + window.innerWidth);

if(window.innerWidth >= 1100) // PC
{
console.log('grand ecran');

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

// Page d'un WS, envoye le formulaire de contact manager en AJAX
$("#manager-contact-form").submit(function (e){
    e.preventDefault();
    $form = $(e.target);
    $.ajax($form.attr('action'), {
        data: $form.serialize(),
        type: "POST",
        success: function(data) { 
          $('#contentToRefresh').html(data);  
        },
        error: function() {
          $('#contentToRefresh').html("Une erreur est survenue, veuillez réessayer plus tard");  
          $('#modal-footer-manager-contact').html('');         
        }
    });
});
// Page d'un WS, envoye le commentaire et le vote en AJAX
$("#comment-form").submit(function (e){
    e.preventDefault();
    $form = $(e.target);
    $.ajax($form.attr('action'), {
        data: $form.serialize(),
        type: "POST",
        success: function(data) {
          $('#CommentResults').html(data);         
        },
        error: function() {
          $('#CommentResults').html("Une erreur est survenue, veuillez réessayer plus tard");
        }
    });
});

// PopIn login via AJAX
$("#formLogin").submit(function (e){
    e.preventDefault();
    $form = $(e.target);
    $.ajax($form.attr('action'), {
        data: $form.serialize(),
        type: "POST",
        success: function(data) {
          if(data.search('help-block') > 0 )
          {
            // Recharge la modal pour afficher les erreurs
            $('#myModalLoginBody').html(data);
          }else{
            window.location.reload();
          }
        },
        error: function() {
          $('#myModalLoginBody').html("Une erreur est survenue, veuillez réessayer plus tard");
        }
    });
});
// PopIn inscription via AJAX
$("#formRegister").submit(function (e){
    e.preventDefault();
    $form = $(e.target);
    $.ajax($form.attr('action'), {
        data: $form.serialize(),
        type: "POST",
        success: function(data) {
          $('#myModalRegisterBody').html(data);  
        },
        error: function() {
          $('#myModalRegisterBody').html("Une erreur est survenue, veuillez réessayer plus tard");
        }
    });
});
// PopIn MDP via AJAX
$("#formMDP").submit(function (e){
    e.preventDefault();
    $form = $(e.target);
    $.ajax($form.attr('action'), {
        data: $form.serialize(),
        type: "POST",
        success: function(data) {
          // Ici dans tous les cas on reload la modal car le controller est surchargé
          $('#myModalMDPBody').html(data);  
        },
        error: function() {
          $('#myModalMDPBody').html("Une erreur est survenue, veuillez réessayer plus tard");
        }
    });
});
// PopIn change MDP via AJAX
$("#formChangeMDP").submit(function (e){
    e.preventDefault();
    $form = $(e.target);
    $.ajax($form.attr('action'), {
        data: $form.serialize(),
        type: "POST",
        success: function(data) {
          // Ici dans tous les cas on reload la modal car le controller est surchargé
          $('#myModalChangeMDPBody').html(data);  
        },
        error: function() {
          $('#myModalChangeMDPBody').html("Une erreur est survenue, veuillez réessayer plus tard");
        }
    });
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



// Smooth scrolling for home button
$("#goToMap").unbind("click").click(function(e){
    e.preventDefault();
    $('html, body').animate({ scrollTop: $($(this).attr('href')).offset().top}, 1000, 'linear');
});

$("#goToDeclare").unbind("click").click(function(e){
    e.preventDefault();
    $('html, body').animate({ scrollTop: $($(this).attr('href')).offset().top}, 1000, 'linear');
});

$('[id^="goToResa-"]').click(function() {
  $('#myTab a[href="#Réservation"]').tab('show');
});

$('[id^="goToContact"]').click(function() {
  $('#myTab a[href="#Contact"]').tab('show');
});

$('[id^="goToContact-"]').click(function() {
  $('#myTab a[href="#Contact"]').tab('show');
  $('#myModalManagerContact').modal({});
});

/****************** Page d'un WS, caroussel ****************/
$(document).ready(function () {
  $('#myCarousel').carousel({
    interval: false
            //interval: 2000
  });
  $('.small-thumbnail img').click(function () {
    $('#DataDisplay').attr("src", $(this).attr("data-display"));
  });

  // Modif Olivia sinon le slider ajoute l'image dans l'image et ca casse mes onglets
  $('#myCarousel').bind('click', function (e) {
    e.preventDefault();
  });

});

/****************** Page d'un WS, slider liste de WS en réseau ****************/
$(document).ready(function(){
  $('#sliderNetwork').bxSlider({
    slideWidth: 400,
    minSlides: 2,
    maxSlides: 3,
    moveSlides: 1,
    slideMargin: 20
  });
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


/********** Home filter menu ***********/
// jplist.com

$(document).ready(function(){
   $('#WsFilters').jplist({       
      itemsBox: '.list' 
      ,itemPath: '.list-item' 
      ,panelPath: '.jplist-panel' 
      ,noResults: '.jplist-no-results'
   });
   
});





// HOme page Map
$("#modalMap").on('click', function(event){
   initMap();
});

function initMap() {

  var locations = [
  ["Mutualab",50.63,3.062],
  ["La Coroutine",50.629,3.07],
  ["Co-factory",50.656,3.087],
  ["1624 Cowork'in Lille",50.641,3.066],
  ["Wereso Lille",50.635,3.058],
  ["La maison d'Alfred",50.689,3.176],
  ["Be Square",50.693,3.17],
  ["La maison du coworking",50.609,3.167],
  ["Réactif & Co",50.755,3.131],
  ["La plaine images",50.7,3.157],
  ["Noya",50.63862659999999,3.076176499999974]
];

  var infowindow = new google.maps.InfoWindow(); /* SINGLE */
  var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 3,
      center: new google.maps.LatLng(50.62924999999999, 3.057256000000052) // Lille
  });
  
  function placeMarker( loc ) {
    var latLng = new google.maps.LatLng( loc[1], loc[2]);
    var marker = new google.maps.Marker({
      position : latLng,
      map      : map
    });
    google.maps.event.addListener(marker, 'click', function(){
        infowindow.close(); // Close previously opened infowindow
        infowindow.setContent( "<div id='content'><div id='siteNotice'></div><h2>"+ loc[0] +"</2></div>");
        infowindow.open(map, marker);
    });
  }
  
  // ITERATE ALL LOCATIONS
  // Don't create functions inside for loops
  // therefore refer to a previously created function
  // and pass your iterating location as argument value:
  for(var i=0; i<locations.length; i++) {
    placeMarker( locations[i] );
  } 
  
  $("#myModalMap").modal('show');
}

}
else if(window.innerWidth >= 900) // PC & tablette
{

// Gestion des URL distincts pour chaque onglet dans page d'un WS
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

}else
{ ///////////////////////////////////////////////////////////////////////////// JS for mobile only
console.log('mobile');
// /***************** filtre sur home page *************************/
// $('#filtre-mobile').on('change', function() { 
//   console.log('OK');
//   var text = document.querySelector('input[name="filtre-mobile"]:checked').value;
//     $('ul.listed-values li').hide();
//     $('ul.listed-values li').filter(function(){
//        return $(this).attr('class').indexOf(text) != -1;
//     }).show();
// });

}

if(window.innerWidth >= 900 && window.innerWidth < 1200 ) // Tablet et mobile but no PC
/****************** slider des images d'un WS ****************/
// http://bxslider.com/
$(document).ready(function(){
  $('#slider-mobile').bxSlider({
    slideWidth: window.innerWidth,
    minSlides: 1,
    maxSlides: 1,
    moveSlides: 1,
    slideMargin: 0
  });
});

