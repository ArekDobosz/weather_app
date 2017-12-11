
$(document).ready(function() {

	let cityOutput = $('#cityOutput');
	let countryOutput = $('#countryOutput');
	let searchingCity = $('input[name="city"]');
	let searchResult = $('#cityName');
	let myCity = $('#myCity');
	let cityName;
	let lat;
	let lng;

	showWatherDetails = function (result) {

		let rainfall = result.daily.data[0].precipType;
		let hourlyData = result.hourly;
		let summary = hourlyData.summary;
		let datas = hourlyData.data;
		let temperature = (datas[0].temperature - 32)/1.8;
			temperature = Math.floor(temperature * 10) / 10 + '&#x2103;';
		// let icon = "{{ asset('img/'" + datas[0].icon + ".svg') }}";
		let date = new Date(null);
		
		date.setSeconds(datas[0].time);
		// console.log(date.toISOString());

		let img = $('<img src="img/' + datas[0].icon + '.png" width="100">');
		$('#icon')
			.children()
			.remove();
		$('#icon').html(img);
		$('#temp').html("Temperatura powietrza " + temperature);
		$('#humi').html("Wilgotność " + datas[0].humidity * 100 + "%");
		$('#wind').html("Siła wiatru " + datas[0].windSpeed + "m/s");
		$('#uvIn').html("Indeks promieniowania " + datas[0].uvIndex);

		myCity.val(cityName);
		$('#form').show();

		// let text = summary + "\n Temperatura: " + Math.floor(temperature * 10) / 10 + '&#x2103;' + 
		// ", Wilgotność: " + datas[0].humidity * 100 + "%, siła wiatru: " + datas[0].windSpeed + 
		// "m/s, indeks promieniowania UV: " + datas[0].uvIndex;


		// $('#details')
		// 	.html(text);
		// $('#icon')
		// 	.children()
		// 	.remove();
		// $('#icon')
		// 	.append(img);
	}

	successSearchRequest = function (result) {

		if(result.status == "ZERO_RESULTS") {

			searchResult.text("Brak wyników dla zapytania");
		}
		if(result.status == "OK") {
			
			cityName = result.results[0].address_components[0].long_name;

			searchResult.text(cityName);
			myCity.text(cityName);

 			let darksky = "https://api.darksky.net/forecast/";
 			let darkskyKey = "8676a9ca8d3ed7e785fb490ee18b6635";

			lat = result.results[0].geometry.location.lat;
			lng = result.results[0].geometry.location.lng;

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

       	var method = 'GET';
       	var url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='+latitude+','+longitude+'&sensor=true';
       	let city, country;

       	$.ajax({
       		url: url,
       		method: method,
       		dataType: "json"
       	}).done(function (result) {
       		if(!result.results[0].address_components) {
       			cityOutput.text('Błąd serwera. Odśwież stronę.');
       		} else {
	       		var data = result.results[0].address_components;

	       		for (i = 0; i < data.length; i++) {
	       			if(data[i].types[0] == "locality") {
	       				city = data[i].long_name;
	       				cityOutput.text(city);
	       			}
	       			if(data[i].types[0] == "country") {
	       				country = data[i].long_name;
	       				countryOutput.text(country);
	       			}
	       		}
	       		searchingCity.val(city);
		  //      	if(searchingCity.val() == "") {
				// 	getWeather(city);
				// }      			
       		}
       	}).fail(function (result) {
       		cityOutput.text('Błąd serwera. Odśwież aby naprawić.');
       	});
    }

	var successCallback = function (position){
		var x = position.coords.latitude;
		var y = position.coords.longitude;
		displayLocation(x,y);
	};

	navigator.geolocation.getCurrentPosition(successCallback);

	// WYSZUKIWANIE MIASTA
	$('#submit_btn').click(function(e) {

		e.preventDefault();

		let search = searchingCity.val();

		getWeather(search);

		return false;			
	});

	// DODAWANIE PREFERENCJI
	$('#preferences').click(function(e) {
		e.preventDefault();

		$(this).addClass('disabled').text('Czekaj...');


		let emailInput = $('input[name="email"]');
		emailInput
			.parent()
			.removeClass('has-error')
			.children()
			.last()
			.html("");

		let url = "/weather_app/public/preferences";

		$.ajax({
			headers: {
				    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  	},
			url: url,
			type: "POST",
			dataType: "json",
			data: {
				cityName: cityName,
				lat: lat,
				lng: lng,
				max_temp: $('input[name="max_temp"]').val(),
				min_temp: $('input[name="min_temp"]').val(), 
				radiation: $('input[name="radiation"]').val(),
				max_humidity: $('input[name="max_humidity"]').val(),
				min_humidity: $('input[name="min_humidity"]').val(),
				wind: $('input[name="wind_v"]').val(),
				email: $('input[name="email"]').val(),
			},
		}).done(function(result) {
			$('#preferences_form').hide();
			$('#title').hide();
			let msg = '. Aby je edytować skorzystaj z odnośnika wysłanego na adres e-mail.';
			$('.panel').
				append($('<h4 class="text-center">' + result + msg + '</h4>'));
		}).fail(function(result) {
			$(this).removeClass('disabled').text('Zapisz zmiany');
			let json = JSON.parse(result.responseText);
			if (json.errors['email']) {
				emailInput
					.parent()
					.addClass('has-error')
					.children()
					.last()
					.html(json.errors['email']);
			}
		});

		return false;
	});
});