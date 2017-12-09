
$(document).ready(function() {

	let cityOutput = $('#cityOutput');
	let countryOutput = $('#countryOutput');
	let searchingCity = $('input[name="city"]');
	let searchResult = $('#searchResult');
	let myCity = $('#myCity');

	showWatherDetails = function (result) {

		let rainfall = result.daily.data[0].precipType;
		console.log(rainfall);
		let hourlyData = result.hourly;
		let summary = hourlyData.summary;
		let datas = hourlyData.data;
		let temperature = (datas[0].temperature - 32)/1.8;
		let icon = "{{ asset('img/'" + datas[0].icon + ".svg') }}";
		console.log(icon);

		let date = new Date(null);
		date.setSeconds(datas[0].time);
		console.log(date.toISOString());

		let text = summary + "\n Temperatura: " + Math.floor(temperature * 10) / 10 + '&#x2103;' + 
		", Wilgotność: " + datas[0].humidity * 100 + "%, siła wiatru: " + datas[0].windSpeed + 
		"m/s, indeks promieniowania UV: " + datas[0].uvIndex;

		let img = $('<img src="img/' + datas[0].icon + '.svg" width="100">');

		$('#details')
			.html(text);
		$('#icon')
			.children()
			.remove();
		$('#icon')
			.append(img);
	}

	successSearchRequest = function (result) {

		if(result.status == "ZERO_RESULTS") {

			searchResult.text("Brak wyników dla zapytania");
		}
		if(result.status == "OK") {
			
			let cityName = result.results[0].address_components[0].long_name;

			searchResult.text(cityName);
			myCity.text(cityName);

 			let darksky = "https://api.darksky.net/forecast/";
 			let darkskyKey = "8676a9ca8d3ed7e785fb490ee18b6635";

			let lat = result.results[0].geometry.location.lat;
			let lng = result.results[0].geometry.location.lng;

			let darkskyUrl = darksky + darkskyKey + "/" + lat + "," + lng;
			
			$.ajax({
				url: darkskyUrl,
				type: "GET",
				dataType: "json",
				beforeSend: function(xhr) {

				},
			}).done(showWatherDetails);					
		}
	}

	failSearchRequest = function() {
		console.log('coś poszło nie tak');
	}

	function getWeather (search) {

		let api_url = "https://maps.googleapis.com/maps/api/geocode/json?address=" + search + "&key=AIzaSyBhib9s-YIBVgkv0-wTQngahHITCVSRo6U";

			$.ajax({
				url: api_url,
				dataType: "json",
				beforeSend: function(xhr) {
					searchResult.text('Wyszukuję...');
				},
			})
			.done(successSearchRequest)
			.fail(failSearchRequest);

	}

    function displayLocation (latitude,longitude) {

    	var request = new XMLHttpRequest();

       	var method = 'GET';
       	var url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='+latitude+','+longitude+'&sensor=true';
       	var async = true;
       	let city, country;

   		request.open(method, url, async);
   		request.onreadystatechange = function(){
	       if(request.readyState == 4 && request.status == 200){
	         	var data = JSON.parse(request.responseText);
	         	// alert(request.responseText); 
	         	var addressComponents = data.results[0].address_components;
	         	for (i = 0; i < addressComponents.length; i++) {

	            	var types = addressComponents[i].types

		            if(types=="locality,political") {
		            	city = addressComponents[i].long_name;
		               	cityOutput.text(city); // CITY
		               	console.log(city);
		            }
		            if(types=="country,political") {
		            	country = addressComponents[i].long_name;
		            	countryOutput.text(country); // COUNTRY
		            }
	           	}

       			if(searchingCity.val() == "") {
   					getWeather(city);
   				}
   			}
		}; 
		request.onerror = function() {
			countryOutput.val("Coś poszło nie tak, spróbuj ponownie za chwilę")
		}  		
			request.send();			
		};

	var successCallback = function (position){
		var x = position.coords.latitude;
		var y = position.coords.longitude;
		displayLocation(x,y);
	};

		navigator.geolocation.getCurrentPosition(successCallback);

		$('#submit_btn').click(function(e) {

			e.preventDefault();

			let search = searchingCity.val();

			getWeather(search);

			return false;			
		})
});