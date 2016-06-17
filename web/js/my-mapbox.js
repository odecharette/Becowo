$(document).ready(function() {
	L.mapbox.accessToken = 'pk.eyJ1Ijoib2RlY2hhcmV0dGUiLCJhIjoiY2lwZ3dkeWVxMDAweHZia3dmeXY4amVrMyJ9.GR0tD6XtoQjSfe3M4C2NrA';
	  
	//var g = {{workspacesInJson|raw}};
	var mapdiv = document.getElementById('map-geojson');
	var g = JSON.parse(mapdiv.getAttribute('data-json'));


	var map = L.mapbox.map('map', 'odecharette.0dg2cjol')
        .setView([46.52863469527167,2.43896484375], 5);

	map.scrollWheelZoom.disable();	// disabled zoom avec la roulette de la souris
       

  	var listings = document.getElementById('listings');
  	var locations = L.mapbox.featureLayer().addTo(map);
	 locations.setGeoJSON(g);

	  function setActive(el) {
	    var siblings = listings.getElementsByTagName('div');
	    for (var i = 0; i < siblings.length; i++) {
	      siblings[i].className = siblings[i].className
	        .replace(/active/, '').replace(/\s\s*$/, '');
	    }

	    el.className += ' active';
	  }

console.log(locations);

	    locations.eachLayer(function(locale) {

	      // Shorten locale.feature.properties to just `prop` so we're not
	      // writing this long form over and over again.
	    var prop = locale.feature.properties;

	      // Each marker on the map.
	    var popup = '<a href = ' + Routing.generate('becowo_core_workspace', {name: prop.name}) + '><h3>' 
	    			+ prop.name + '</h3>' 
	    			+ prop.street + '<br>' 
	    			+ prop.city + '</a>';

	    // inlus la div 'vignette' construite ds home.html.twig
	    var listing = listings.appendChild(document.getElementById('vignette-'+prop.id));
	    var link = document.getElementById('link-'+prop.id);

	    link.onclick = function clickVignette() {
	        setActive(listing);

	        // When a menu item is clicked, animate the map to center its associated locale and open its popup.
		    map.setView(locale.getLatLng(), 16);
		    locale.openPopup();
		    return false;
		    };
		    

	      // Marker interaction
	      locale.on('click', function(e) {
	          // 1. center the map on the selected marker.
	          map.panTo(locale.getLatLng());
	          // 2. Set active the markers associated listing.
	          setActive(listing);
	      });

	      popup += '</div>';
	      locale.bindPopup(popup);

	    var mapmarker = document.getElementById('map-marker');
		var icon = mapmarker.getAttribute('data-path');

	      locale.setIcon(L.icon({
			  iconUrl: icon,	
			  iconSize: [56, 56],
			  iconAnchor: [28, 28],
			  popupAnchor: [0, -34]
			}));
	    });

   // Search box
  //  	var searchBtn = document.getElementById('btn_search');
  //  	searchBtn.onclick = function() {

		//     // get the value of the search input field
		//     var searchString = $('#search').val().toLowerCase();
		//     locations.setFilter(showState);

		//     // here we're simply comparing the 'state' property of each marker
		//     // to the search string, seeing whether the former contains the latter.
		//     function showState(feature) {
		//         return feature.properties.state
		//             .toLowerCase()
		//             .indexOf(searchString) !== -1;
		//     }
		// };
});