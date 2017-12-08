@extends('layouts.layout')

@section('content')
		
	<div id="floating-panel">
      <input id="address" type="textbox" value="">
      <input id="submit" type="button" value="Geocode">
    </div>
    <div id="map" style="height: 300px; width: 100%;"></div>
    <div id="pos"></div>



<script>
		
    var adressOutput = document.getElementById('address');
    var latitude;
    var longitude;

	function getLocation() {
	    if (navigator.geolocation) {
	        navigator.geolocation.getCurrentPosition(showPosition, showError);

	       
	    } else { 
	        // x.innerHTML = "Geolocation is not supported by this browser.";
	    }
	}

	function showPosition(position) {
		// console.log(position);
		latitude = position.coords.latitude;
		longitude = position.coords.longitude;
	    adressOutput.value = "Latitude: " + position.coords.latitude + 
	    "<br>Longitude: " + position.coords.longitude;
	}

	function showError(error) {
	    switch(error.code) {
	        case error.PERMISSION_DENIED:
	            x.innerHTML = "User denied the request for Geolocation."
	            break;
	        case error.POSITION_UNAVAILABLE:
	            x.innerHTML = "Location information is unavailable."
	            break;
	        case error.TIMEOUT:
	            x.innerHTML = "The request to get user location timed out."
	            break;
	        case error.UNKNOWN_ERROR:
	            x.innerHTML = "An unknown error occurred."
	            break;
	    }
	}
	// getLocation();
	// console.log(latitude, longitude);
      function initMap() {
      	var w, sz;
      	if (navigator.geolocation) {
	        navigator.geolocation.getCurrentPosition(function(pos) {
	        	w = pos.coords.latitude;
	        	sz = pos.coords.longitude;
	        	console.log(w, sz);
	        	var map = new google.maps.Map(document.getElementById('map'), {
		          zoom: 8,
		          center: {lat: w, lng: sz},
          
        });
	        }, function() {})
	    }
      	console.log(w, sz);
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 8,
          center: new google.maps.LatLng(latitude, longitude)
          // {lat: latitude, lng: longitude},
          // mapTypeId: google.maps.mapTypeId.TERRAIN
        });

        // console.log(map);
        var geocoder = new google.maps.Geocoder();

        document.getElementById('submit').addEventListener('click', function() {
          geocodeAddress(geocoder, map);
        });

        
      }

      function geocodeAddress(geocoder, resultsMap) {
        var address = document.getElementById('address').value;
        geocoder.geocode({'address': address}, function(results, status) {
          if (status === 'OK') {
            resultsMap.setCenter(results[0].geometry.location);
            // var marker = new google.maps.Marker({
            //   map: resultsMap,
            //   position: results[0].geometry.location
            // });
            console.log(results);
          } else {
            alert('Geocode was not successful for the following reason: ' + status);
          }
        });
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhib9s-YIBVgkv0-wTQngahHITCVSRo6U&callback=initMap">
    </script>

@endsection