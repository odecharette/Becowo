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
