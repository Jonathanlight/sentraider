
window.loadGoogleApi = function() {
    if (document.querySelector(".autocomplete") !== null) {
        initAutocomplete();
        offAutocomplet(document.querySelector(".autocomplete"));
    }
};

let autocomplete;
const componentForm = {
    street_number: 'short_name',
    route: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'short_name',
    administrative_area_level_2: 'short_name',
    country: 'long_name',
    postal_code: 'short_name'
};

// Géolocaliser le user pour récupérer son address dans le moteur de recherche
$( ".geoloc" ).click( function(e) {
    e.preventDefault();

    navigator.geolocation.getCurrentPosition(
        function( position ){ // success

            /* Current Coordinate */
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;
            var google_map_pos = new google.maps.LatLng( lat, lng );

            /* Use Geocoder to get address */
            var google_maps_geocoder = new google.maps.Geocoder();
            google_maps_geocoder.geocode(
                { 'latLng': google_map_pos },
                function( results, status ) {
                    if ( status == google.maps.GeocoderStatus.OK && results[0] ) {
                        $('#search_address').val(results[0].formatted_address);
                        $('.latitude').val(lat);
                        $('.longitude').val(lng);
                    }
                }
            );
        },
    );
});

function offAutocomplet(cyble) {
    setTimeout(function(){ cyble.setAttribute("autocomplete", "off"); }, 1000);
}

function initAutocomplete() {
    autocomplete = new google.maps.places.Autocomplete(
        (document.getElementsByClassName('autocomplete')[0]),
        {
            types: ['geocode'],
            //componentRestrictions: {country: 'fr'}
        }
    );

    autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
    var place = autocomplete.getPlace();

    var lat = place.geometry.location.lat(),
        lng = place.geometry.location.lng();

    $(".latitude").val(lat);
    $(".longitude").val(lng);

    for (var component in componentForm) {
        document.getElementsByClassName(component).value = '';
        document.getElementsByClassName(component).disabled = false;
    }

    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];

        if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            $("."+addressType).val(val);
            document.getElementsByClassName(addressType).value = val;
        }
    }
}

function geolocate() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
                center: geolocation,
                radius: position.coords.accuracy
            });

            autocomplete.setBounds(circle.getBounds());
        });
    }
}
