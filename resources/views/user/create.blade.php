@extends('layouts.layout');

@section('details')		

	<!-- <div class="col-md-6">
		<h2 id="searchResult"></h2>				
	</div>
	<div class="col-md-6">
		<div id="icon"></div>
		<h4 id="details"></h4>
	</div> -->

	<div class="col-md-6">
		<h2 id="cityName">Aby sprawdzić pogodę wyszukaj miasto</h2>				
	</div>

	<div class="col-md-6">
		<div id="icon"><img src="{{ asset('img/partly-cloudy-day.png') }}" width="100"></div>
		<div>
			
			<ul class="weather_details">
				<li id="temp"></li>
				<li id="humi"></li>
				<li id="wind"></li>
				<li id="uvIn"></li>
			</ul>

		</div>
	</div>

@endsection

@section('form')
	<div id="form">
		@include('preferences.create')		
	</div>

@endsection

@section('script')

	<script src="{{ asset('js/script.js') }}"></script>

@endsection