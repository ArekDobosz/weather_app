@extends('layouts.layout');

@section('details')		

	<div class="col-md-6">
		<h2 id="searchResult"></h2>				
	</div>
	<div class="col-md-6">
		<div id="icon"></div>
		<h4 id="details"></h4>
	</div>

@endsection

@section('form')

	@include('preferences.create')

@endsection

@section('script')

	<script src="{{ asset('js/script.js') }}"></script>

@endsection