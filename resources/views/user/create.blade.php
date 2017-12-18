@extends('layouts.layout');

@section('details')		
<div class="panel-heading">
	
		<h3 id="cityName" class="text-center">
			Aby sprawdzić pogodę wyszukaj miasto
		</h3>				

</div>
	<div class="panel-body text-center">
	<div id="details-info"></div>
	<div class="col-md-6 text-right">
		<div id="icon"></div>
	</div>
	<div class="col-md-6 text-left">
		<ul class="weather_details">
			<li id="time"></li>
			<li id="temp"></li>
			<li id="humi"></li>
			<li id="wind"></li>
			<li id="uvIn"></li>
		</ul>

	</div>
</div>

@endsection

@section('form')
		@include('preferences.create')		
@endsection

@section('script')

	<script src="{{ asset('js/script.js') }}"></script>

@endsection