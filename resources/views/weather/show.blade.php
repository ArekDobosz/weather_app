<div class="panel panel-success">
	<div class="panel-heading text-center">
				
		<h5 class="pull-left">
			Twoja aktualna pozycja: 
			<span id="countryOutput"></span>,
			<span id="cityOutput"></span>				
		</h5>
		<div class="pull-right">
			@include('search')
		</div>
	</div>
	<div class="panel-body text-center">
		@include('weather.details_js')
	</div>
</div>