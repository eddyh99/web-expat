
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHJmWb8cmOV3QMTtc561XdQuc3ems19Jw&callback=initAutocomplete&libraries=places&v=weekly"
      defer
></script>

<style>

    #map {
    height: 100%;
    }

    /* 
    * Optional: Makes the sample page fill the window. 
    */
    html,
    body {
    height: 100%;
    margin: 0;
    padding: 0;
    }

    #description {
    font-family: Roboto;
    font-size: 15px;
    font-weight: 300;
    }

    #infowindow-content .title {
    font-weight: bold;
    }

    #infowindow-content {
    display: none;
    }

    #map #infowindow-content {
    display: inline;
    }

    .pac-card {
    background-color: #fff;
    border: 0;
    border-radius: 2px;
    box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
    margin: 10px;
    padding: 0 0.5em;
    font: 400 18px Roboto, Arial, sans-serif;
    overflow: hidden;
    font-family: Roboto;
    padding: 0;
    }

    #pac-container {
    padding-bottom: 12px;
    margin-right: 12px;
    }

    .pac-controls {
    display: inline-block;
    padding: 5px 11px;
    }

    .pac-controls label {
    font-family: Roboto;
    font-size: 13px;
    font-weight: 300;
    }

    /* #pac-input {
    background-color: #fff;
    font-family: Roboto;
    font-size: 15px;
    font-weight: 300;
    margin-left: 12px;
    padding: 0 11px 0 13px;
    text-overflow: ellipsis;
    width: 400px;
    } */

    /* #pac-input:focus {
    border-color: #4d90fe;
    } */

    #title {
    color: #fff;
    background-color: #4d90fe;
    font-size: 25px;
    font-weight: 500;
    padding: 6px 12px;
    }

    #target {
    width: 345px;
    }
</style>
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHJmWb8cmOV3QMTtc561XdQuc3ems19Jw&libraries=places"></script> -->
<script>
    /**
     * @license
     * Copyright 2019 Google LLC. All Rights Reserved.
     * SPDX-License-Identifier: Apache-2.0
     */
    // @ts-nocheck TODO remove when fixed
    // This example adds a search box to a map, using the Google Place Autocomplete
    // feature. People can enter geographical searches. The search box will return a
    // pick list containing a mix of places and predicted search terms.
    // This example requires the Places library. Include the libraries=places
    // parameter when you first load the API. For example:
    // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

    
    function initAutocomplete() {
        const map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: -33.8688, lng: 151.2195 },
            zoom: 13,
            mapTypeId: "roadmap",
        });
        // Create the search box and link it to the UI element.
        const input = document.getElementById("pac-input");
        const searchBox = new google.maps.places.SearchBox(input);

        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        // Bias the SearchBox results towards current map's viewport.
        map.addListener("bounds_changed", () => {
            searchBox.setBounds(map.getBounds());
        });

        let markers = [];

        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener("places_changed", () => {
            const places = searchBox.getPlaces();
            console.log(places);

            if (places.length == 0) {
                return;
            }

            // Clear out the old markers.
            markers.forEach((marker) => {
                marker.setMap(null);
            });
            markers = [];

            // For each place, get the icon, name and location.
            const bounds = new google.maps.LatLngBounds();
            places.forEach((place) => {
                if (!place.geometry || !place.geometry.location) {
                    console.log("Returned place contains no geometry");
                    return;
                }

                console.log(place.geometry.location.lat());
                console.log(place.geometry.location.lng());

                $("#lat").val(place.geometry.location.lat());
                $("#long").val(place.geometry.location.lng());

                $("#prev-address").remove();
                $("#preview-pac-input").append(`
                    <span id="prev-address">
                        <i class="fas fa-map-marker-alt me-2"></i>
                    </span>
                `);
                place.address_components.forEach((address, i) => {
                    $("#prev-address").append(`
                        ${address.short_name},
                    `);
                });

                const icon = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25),
                };

                // Create a marker for each place.
                markers.push(
                    new google.maps.Marker({
                    map,
                    icon,
                    title: place.name,
                    position: place.geometry.location,
                    }),
                );
                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
            map.fitBounds(bounds);
        });
    }

    // initAutocomplete();

    window.initAutocomplete = initAutocomplete;

    // function deg2rad(deg) {
    //     return deg * (Math.PI/180)
    // }

    
    // function getDistanceFromLatLonInKm(lat1,lon1,lat2,lon2) {
    //     var R = 6371; // Radius of the earth in km
    //     var dLat = deg2rad(lat2-lat1);  // deg2rad below
    //     var dLon = deg2rad(lon2-lon1); 
    //     var a = 
    //         Math.sin(dLat/2) * Math.sin(dLat/2) +
    //         Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
    //         Math.sin(dLon/2) * Math.sin(dLon/2)
    //         ; 
    //     var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
    //     var d = R * c; // Distance in km
    //     return d;
    // }

    // console.log(getDistanceFromLatLonInKm(-8.5049596,115.179781,-8.5413679,115.1912804));



    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: 37.7749, lng: -122.4194 }, // San Francisco as center
            zoom: 6
        });

        var directionsService = new google.maps.DirectionsService();
        var directionsRenderer = new google.maps.DirectionsRenderer();

        directionsRenderer.setMap(map);

        var start = { lat: 37.7749, lng: -122.4194 }; // San Francisco
        var end = { lat: 34.0522, lng: -118.2437 }; // Los Angeles

        var request = {
            origin: start,
            destination: end,
            travelMode: 'DRIVING'
        };

        directionsService.route(request, function(result, status) {
            console.log(result);
            console.log(directionsRenderer);
            if (status == 'OK') {
                directionsRenderer.setDirections(result);
            } else {
                alert('Directions request failed due to ' + status);
            }
        });
    }

    window.onload = initMap;
</script>

