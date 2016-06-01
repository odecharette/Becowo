// Charge la mini carte google dans la page d'un WS, selon son adresse dynamique
var q=encodeURIComponent($('#address_ws').text());
       $('#map_ws')
        .attr('src','https://www.google.com/maps/embed/v1/place?key=AIzaSyACES16ClzyOdiVa9Ohd-_unkM5rvvbo7o&q='+q);

//récupérer le vote saisie dans la page d'un WS
$('#vote1').on('rating.change', function(event, value, caption) {
    console.log(value); // Number(value)

});
