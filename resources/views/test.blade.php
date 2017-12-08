@extends('layouts.layout');

@section('content')	

	<div class="panel panel-success">
		<div class="panel-body text-center">
			Twoja aktualna pozycja: 
			<h2 id="countryOutput"></h2>
			<h2 id="cityOutput"></h2>
			<form action="#" method="GET" class="form-inline">
				<div class="col-md-12 text-center">
					<div class="form-group col-md-3 text-right">
						<input type="text" name="city" class="form-control" placeholder="Wyszukaj miasto...">
					</div>
					<div class="col-md-1 text-left">				
						<button id="submit_btn" type="button" class="btn btn-info">Wyszukaj</button>
					</div>
				</div>
			</form>
			<h2>Pogoda dla : </h2>
			<h2 id="searchResult"></h2>
		</div>
	</div> 

@endsection

@section('script')
<script>
    $(document).ready(function(){

    	let cityOutput = $('#cityOutput');
    	let countryOutput = $('#countryOutput');

        function displayLocation(latitude,longitude){

        	var request = new XMLHttpRequest();

	       	var method = 'GET';
	       	var url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='+latitude+','+longitude+'&sensor=true';
	       	var async = true;

       		request.open(method, url, async);
       		request.onreadystatechange = function(){
		       if(request.readyState == 4 && request.status == 200){
		         	var data = JSON.parse(request.responseText);
		         	// alert(request.responseText); 
		         	var addressComponents = data.results[0].address_components;
		         	for (i = 0; i < addressComponents.length; i++) {

		            	var types = addressComponents[i].types

			            if(types=="locality,political") {
			               	cityOutput.text(addressComponents[i].long_name); // CITY
			            }
			            if(types=="country,political") {
			            	countryOutput.text(addressComponents[i].long_name); // COUNTRY
			            }
		           	}
       			}
    		};
   			request.send();
 		};

		var successCallback = function(position){
			var x = position.coords.latitude;
			var y = position.coords.longitude;
			displayLocation(x,y);
		};

 		navigator.geolocation.getCurrentPosition(successCallback);

 		let searchingCity = $('input[name="city"]');
 		let searchResult = $('#searchResult');
 		let lat;
 		let lng;

 		$('#submit_btn').click(function(e) {
 			e.preventDefault();

 			let search = searchingCity.val();
 			let api_url = "https://maps.googleapis.com/maps/api/geocode/json?address=" + search + "&key=AIzaSyBhib9s-YIBVgkv0-wTQngahHITCVSRo6U";

 			let darksky = "https://api.darksky.net/forecast/";
 			let darkskyKey = "8676a9ca8d3ed7e785fb490ee18b6635";
 			// lat = 53.778422;
 			// lng = 20.4801192;
 			// let uri = darksky + darkskyKey + "/" + lat + "," + lng;
 			// console.log(uri);
 			
 			$.ajax({
 				url: api_url,
 				dataType: "json",
 				beforeSend: function(xhr) {
 					searchResult.text('Wyszukuję...');
 				},
 			}).done(function(result) {
 				if(result.status == "ZERO_RESULTS") {
 					searchResult.text("Brak wyników dla zapytania");
 				}
 				if(result.status == "OK") {
 					// console.log(result);
 					searchResult.text(result.results[0].address_components[0].long_name);
					lat = result.results[0].geometry.location.lat;
					lng = result.results[0].geometry.location.lng;

					let darkskyUrl = darksky + darkskyKey + "/" + lat + "," + lng;
					
					$.ajax({
						url: darkskyUrl,
						type: "GET",
						dataType: "json",
						beforeSend: function(xhr) {

						},
					}).done(function(result) {
						let hourlyData = result.hourly;
						let summary = hourlyData.summary;
						let datas = hourlyData.data;
						console.log(hourlyData);
					});					
 				}
 			}).fail(function() {
 				console.log('coś poszło nie tak');
 			});
 		})

  	});
</script>

@endsection