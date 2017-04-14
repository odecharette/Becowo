// Google Analytics DEMO
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', $('#google_analytics_ID').text(), 'auto');
  ga('send', 'pageview');

// End Google Analytics 

/**
* Fonction de suivi des clics sur des liens sortants dans Analytics
* Cette fonction utilise une chaîne d'URL valide comme argument et se sert de cette chaîne d'URL
* comme libellé d'événement. Configurer la méthode de transport sur 'beacon' permet d'envoyer le clic
* au moyen de 'navigator.sendBeacon' dans les navigateurs compatibles.
*/
var trackOutboundLink = function(url, name, new_window) {
   ga('send', 'event', 'outbound', 'clic', name, {'hitCallback':
    function () {
      if (!new_window) {
        document.location = url;
      }
    }
  });
};

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
// PopIn MDP oublié via AJAX
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


console.log('width de l\'écran : ' + window.innerWidth);

if(window.innerWidth >= 1100) // PC
{
  console.log('grand ecran');
}

if(window.innerWidth >= 900) // PC & tablette
{
console.log('PC et tablette');
// Gestion des URL distincts pour chaque onglet dans page d'un WS
$(function(){
  
  var hash = window.location.hash;

  if(hash == '' || hash == '#!') // #! quand on se connecte via linkedin
  {
    $('.nav-tabs a[href="#Description"]').tab('show')
    var e = document.getElementById('Description');
    if(e){
      e.classList.add("active");
      e.classList.add("in");
    };
  }
  else{
    hash = hash.substring(1, hash.length);
    console.log(hash);
    var e = document.getElementById(hash);
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

  
// Charge la mini carte google dans la page d'un WS, selon son adresse dynamique
var q=encodeURIComponent($('#address_ws').text());
       $('#map_ws')
        .attr('src','https://www.google.com/maps/embed/v1/place?key=AIzaSyACES16ClzyOdiVa9Ohd-_unkM5rvvbo7o&q='+q);


/* Bouton Back to top */

if ( ($(window).height() + 100) < $(document).height() ) {
$('#top-link-block').removeClass('hidden').affix({
    // how far to scroll down before link "slides" into view
    offset: {top:100}
});
}


// Smooth scrolling for home button
$("#goToFilters").unbind("click").click(function(e){
    e.preventDefault();
    $('html, body').animate({ scrollTop: $($(this).attr('href')).offset().top}, 1000, 'linear');
});


$('[id^="goToResa-"]').click(function() {
  $('#myTab a[href="#Reservation"]').tab('show');
});

$('[id^="goToContact"]').click(function() {
  $('#myTab a[href="#Contact"]').tab('show');
});

$('[id^="goToContact-"]').click(function() {
  $('#myTab a[href="#Contact"]').tab('show');
  $('#myModalManagerContact').modal({});
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


}else
{ ///////////////////////////////////////////////////////////////////////////// JS for mobile only
console.log('mobile');

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


function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
}
