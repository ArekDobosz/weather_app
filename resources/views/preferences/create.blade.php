
<h4 id="title">Ustaw powiadomienia dla <span id="myCity">...</span></h4>
<form id="preferences_form" action="{{ url('preferences') }}" method="POST">

	{{ csrf_field() }}
	{{ method_field("POST") }}

	<div class="form-group col-md-3">
		<label for="max_temp">Temperatura powyżej</label>
		<input type="number" name="max_temp" min="-50" max="50" step="3" value="" class="form-control">
	</div>
	<div class="form-group col-md-3">
		<label for="min_temp">Temperatura poniżej</label>
		<input type="number" name="min_temp" min="-50" max="50" step="3" value="" class="form-control">
	</div>
	<div class="form-group col-md-3">
		<label for="radiation">Promieniowanie</label>
		<input type="number" name="radiation" min="0" max="11" step="1" value="" class="form-control">
	</div>
	<div class="form-group col-md-3">
		<label for="max_humidity">Wilgotność powyżej</label>
		<input type="number" name="max_humidity" min="0" max="100" step="5" value="" class="form-control">
	</div>
	<div class="form-group col-md-3">
		<label for="min_humidity">Wilgotność poniżej</label>
		<input type="number" name="min_humidity" min="0" max="100" step="5" value="" class="form-control">
	</div>
	<div class="form-group col-md-3">
		<label for="wind_v">Siła wiatru</label>
		<input type="number" name="wind_v" min="0" max="200" step="10" value="" class="form-control">
	</div>
	<div class="form-group col-md-6">
		<label for="email">Adres e-mail</label>
		<input type="email" name="email" value="" class="form-control" required>
		<div class="help-block"></div>
	</div>
	<input type="hidden" name="cityName" value="">
	<input type="hidden" name="lat" value="">
	<input type="hidden" name="lng" value="">
	<div class="col-md-6 pull-right">
		<label></label>
		<button id="preferences" type="submit" class="btn btn-info btn-block">Zapisz zmiany</button>
	</div>
</form>
