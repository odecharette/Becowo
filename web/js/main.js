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
