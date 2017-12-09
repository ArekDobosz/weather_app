@extends('layouts.layout');

@section('content')	

	<div class="panel panel-success">
		<div class="panel-body text-center">
			<div class="col-md-6">
				Twoja aktualna pozycja: 
				<span id="countryOutput"></span>,
				<span id="cityOutput"></span>				
			</div>
			<div class="col-md-6">

				@include('search')

				<hr>
			</div>
			<div class="col-md-6">
				<h2 id="searchResult"></h2>				
			</div>
			<div class="col-md-6">
				<div id="icon"></div>
				<h4 id="details"></h4>
			</div>
			<hr>
			<div class="col-md-12">
				<h4>Ustaw powiadomienia dla <span id="myCity">...</span></h4>
				@include('preferences.preferences')
			</div>
		</div>
	</div> 

@endsection

@section('script')

	<script src="{{ asset('js/script.js') }}"></script>

@endsection