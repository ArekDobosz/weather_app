function setPrefix (pre) {
	const prefix = pre;
}
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
		if(typeof(prefix) != 'undefined') { console.log('ok') }
		let asset = 'img/' + result.icon + '.png';

		let img = $('<img src=' + asset + ' width="150">');

		$('#icon')
			.children()
			.remove();
		$('#icon').html(img);
		$('#temp').html("Temperatura powietrza " + result.temperature + "&#x2103;");
		$('#humi').html("Wilgotność " + result.humidity + "%");
		$('#wind').html("Siła wiatru " + result.wind + "m/s");
		$('#uvIn').html("Indeks promieniowania " + result.uvIndex);

		myCity.val(cityName);
		$('#preferences_div').removeClass('hidden');
	}

	successSearchRequest = function (result) {

		if(result.status == "ZERO_RESULTS") {

			searchResult.text("Brak wyników dla zapytania");
		}
		if(result.status == "OK") {
			
			cityName = result.results[0].address_components[0].long_name;

			searchResult.text(cityName);
			myCity.text(cityName);

			lat = result.results[0].geometry.location.lat;
			lng = result.results[0].geometry.location.lng;

			let url = '/weather_app/public/weather/' + lat + '/' + lng + '/' + cityName;

			$('input[name="cityName"]').val(cityName);
			$('input[name="lat"]').val(lat);
			$('input[name="lng"]').val(lng);
			
			$.ajax({
				url: url,
				type: "GET",
				dataType: "json",
				beforeSend: function(xhr) {

				},
			}).done(showWatherDetails);					
		}
	}

	failSearchRequest = function() {
		if (searchingCity.val() == "") {
			searchResult.text("Należy wpisać szukaną wartość w polu wyszukiwania")
		} else {

		searchResult.text('Błąd serwera. Proszę odśwież stronę.')		
		}
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
       		try {
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
       		} catch(e){
       			cityOutput.text("Spróbuj ponownie");
       			countryOutput.text('');
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


	// INICJALIZACJA GEOLOKACJI
	function showError(error) {
	    switch(error.code) {
	        case error.PERMISSION_DENIED:
	            x.innerHTML = "Brak pozwolenie na geolokalizację."
	            break;
	        case error.POSITION_UNAVAILABLE:
	            x.innerHTML = "Nie można ustalić pozycji."
	            break;
	        case error.TIMEOUT:
	            x.innerHTML = "Minął czas oczekiwania na przetworzenie żądania."
	            break;
	        case error.UNKNOWN_ERROR:
	            x.innerHTML = "Nieoczekiwany błąd."
	            break;
	    }
	}

	$('#set_position').click(function (e) {
		if(!navigator.geolocation) {
			cityOutput("Twoja przeglądarka nie wspiera geolokalizacji.")
		} else {
			navigator.geolocation.getCurrentPosition(successCallback, showError);		
		}
		return false;		
	})

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
		let btn = $(this);
		btn.addClass('disabled').text('Czekaj...');

		let errors = document.querySelectorAll('.has-error');
		
		for (i = 0; i < errors.length; i++) {
			error = errors[i].children[2].innerHTML = '';
			errors[i].classList.remove('has-error');
		}

		let url = "/weather_app/public/preferences";

		$.ajax({
			headers: {
				    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  	},
			url: url,
			type: "POST",
			dataType: "json",
			data: {
				cityName: typeof(cityName) != 'undefined' ? cityName : $('input[name="cityName"]').val(),
				lat: typeof(lat) != 'undefined' ? lat : $('input[name="lat"]').val(),
				lng: typeof(lng) != 'undefined' ? lng : $('input[name="lng"]').val(),
				max_temp: $('input[name="max_temp"]').val(),
				min_temp: $('input[name="min_temp"]').val(), 
				radiation: $('input[name="radiation"]').val(),
				max_humidity: $('input[name="max_humidity"]').val(),
				min_humidity: $('input[name="min_humidity"]').val(),
				wind: $('input[name="wind"]').val(),
				email: $('input[name="email"]').val(),
			},
		}).done(function(result) {

			$('#preferences_div').hide();

			let msg = '. Aby je edytować skorzystaj z odnośnika wysłanego na adres e-mail.';

			$('#info_panel').
				append($('<h4 class="text-center">' + result + msg + '</h4>'));
		}).fail(function(result) {
			btn.removeClass('disabled')
			btn.text('Dodaj preferencje');
			let json = JSON.parse(result.responseText);
			$.each(json.errors, function (key, val) {
				displayErrors(key, val);
			})
		});

		return false;
	});

	function displayErrors(inputName, error) {
		input = $('input[name="'+ inputName +'"]');
		input
			.parent()
			.addClass('has-error')
			.children()
			.last()
			.html(error);
	}
});