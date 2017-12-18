@extends('layouts.layout');

@section('details')	

	<div class="panel-heading">
		<div class="text-center"><h4>Witaj {{ $user->email }}!</h4></div>	
	</div>

	<div class="panel-body text-center">
	<div class="col-md-12 text-center">
		<h2 id="cityName">{{ $user->place->name }}</h2>				
	</div>
	<div id="details-info"></div>
	<div class="col-md-6 text-right">
		<div id="icon">
			<img id="weather_icon" src="{{ asset('img/'.$user->place->icon.'.png') }}" width="150">
		</div>
	</div>
	<div class="col-md-6 text-left">
			
			<ul class="weather_details">
				<li id="time">Dane na dzień {{ $user->place->time }}</li>
				<li id="temp">Temperatura powietrza {{ $user->place->temperature }}&#x2103;</li>
				<li id="humi">Wilgotność {{ $user->place->humidity }}%</li>
				<li id="wind">Siła wiatru {{ $user->place->wind }} m/s</li>
				<li id="uvIn">Indeks promieniowania {{ $user->place->radiation }}</li>
			</ul>

		</div>
	</div>

@endsection

@section('form')

	@include('preferences.edit')

@endsection

@section('script')
	
	<script src="{{ asset('js/script.js') }}"></script>

@endsection