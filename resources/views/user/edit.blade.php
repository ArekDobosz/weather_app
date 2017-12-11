@extends('layouts.layout');

@section('details')	

	<div class="col-md-12">Witaj <strong>{{ $user->email }}</strong>!</div>	

	<div class="col-md-6">
		<h2 id="cityName">{{ $user->place->name }}</h2>				
	</div>
	<div class="col-md-6">
		<div id="icon"><img src="{{ asset('img/partly-cloudy-day.png') }}" width="100"></div>
		<div>
			
			<ul class="weather_details">
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