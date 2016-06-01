// Charge la mini carte google dans la page d'un WS, selon son adresse dynamique
var q=encodeURIComponent($('#address_ws').text());
       $('#map_ws')
        .attr('src','https://www.google.com/maps/embed/v1/place?key=AIzaSyACES16ClzyOdiVa9Ohd-_unkM5rvvbo7o&q='+q);

//récupérer le vote saisie dans la page d'un WS
$('#vote1').on('rating.change', function(event, value, caption) {
    //console.log(value); // Number(value)

    //var ws_name = "{{ ws.name|json_encode() }}";
    var ws_name = "Mutualab";
    // TO DO récupérer en dynamique le name du WS en cours + le membre qui vote s'il est connecté
    console.log(ws_name);
    Routing.generate('becowo_core_workspace_vote', {vote: value});
    $.ajax({
   			url: Routing.generate('becowo_core_workspace_vote', {vote: Number(value), name: ws_name, member: 1})
			});
});
