$(document).ready(function() {
	L.mapbox.accessToken = 'pk.eyJ1Ijoib2RlY2hhcmV0dGUiLCJhIjoiY2lwZ3dkeWVxMDAweHZia3dmeXY4amVrMyJ9.GR0tD6XtoQjSfe3M4C2NrA';
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

	  	//////////// Génération des markers
	    locations.eachLayer(function(locale) {
		var prop = locale.feature.properties;
	    
	    // on ne charge que les marker de type Workspace
	    if (prop.type == 'workspace') {
	    
		    /////////////// Pop-up
		    var popup = '<a href = ' + Routing.generate('becowo_core_workspace', {name: prop.name}) + '><h3>' 
		    			+ prop.name + '</h3>' 
		    			+ prop.street + '<br>' 
		    			+ prop.city + '</a>';

		    /////////////// inlus la div 'vignette' construite ds home.html.twig
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
		          map.panTo(locale.getLatLng());
		          setActive(listing);
		      });

		      popup += '</div>';
		      locale.bindPopup(popup);

	    }});

	    ///////////////////////////////// Filters
	    var filters = document.getElementById('filters');

	    map.featureLayer.on('ready', function() {
	  var types = ['Creche collective', 'Creche familiale'];

	  var checkboxes = [];
	  // Create a filter interface.
	  for (var i = 0; i < types.length; i++) {
	    // Create an input checkbox and label inside.
	    var item = filters.appendChild(document.getElementById('filters-div1'));
	    var checkbox = item.appendChild(document.createElement('input'));
	    var label = item.appendChild(document.createElement('label'));
	    checkbox.type = 'checkbox';
	    checkbox.id = types[i];
	    checkbox.checked = true;
	    // create a label to the right of the checkbox with explanatory text
	    label.innerHTML = types[i];
	    label.setAttribute('for', types[i]);
	    // Whenever a person clicks on this checkbox, call the update().
	    checkbox.addEventListener('change', update);
	    checkboxes.push(checkbox);
	  	}

		  // This function is called whenever someone clicks on a checkbox and changes
		  // the selection of markers to be displayed.
		  function update() {
		    var enabled = {};
		    // Run through each checkbox and record whether it is checked. If it is,
		    // add it to the object of types to display, otherwise do not.
		    for (var i = 0; i < checkboxes.length; i++) {
		      if (checkboxes[i].checked) enabled[checkboxes[i].id] = true;
		    }
		    // on ajoute tjs les WS pour qu'ils restent affichés
		    enabled['workspace'] = true

		    locations.setFilter(function(feature) {
		      // If this symbol is in the list, return true. if not, return false.
		      return (feature.properties.type in enabled);
		    });
		  }
		});




});