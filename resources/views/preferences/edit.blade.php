
<h4 id="title">Twoje powiadomienia dla <span id="myCity">{{ $user->place->name }}</span></h4>
<form id="preferences_form" action="#" method="POST">

	{{ csrf_field() }}

	<div class="form-group col-md-4">
		<label for="max_temp">Temperatura powyżej</label>
		<input type="number" name="max_temp" min="-50" max="50" step="3" value="{{ $user->max_temperature }}" class="form-control">
	</div>
	<div class="form-group col-md-4">
		<label for="min_temp">Temperatura poniżej</label>
		<input type="number" name="min_temp" min="-50" max="50" step="3" value="{{ $user->min_temperature }}" class="form-control">
	</div>
	<div class="form-group col-md-4">
		<label for="radiation">Promieniowanie</label>
		<input type="number" name="radiation" min="0" max="11" step="1" value="{{ $user->radiation }}" class="form-control">
	</div>
	<div class="form-group col-md-4">
		<label for="max_humidity">Wilgotność powyżej</label>
		<input type="number" name="max_humidity" min="0" max="100" step="5" value="{{ $user->max_humidity }}" class="form-control">
	</div>
	<div class="form-group col-md-4">
		<label for="min_humidity">Wilgotność poniżej</label>
		<input type="number" name="min_humidity" min="0" max="100" step="5" value="{{ $user->min_humidity }}" class="form-control">
	</div>
	<div class="form-group col-md-4">
		<label for="wind_v">Siła wiatru</label>
		<input type="number" name="wind_v" min="0" max="200" step="10" value="{{ $user->wind }}" class="form-control">
	</div>
	<div class="col-md-4 pull-right">
		<label></label>
		<button id="preferences" type="button" class="btn btn-info btn-block">Zapisz zmiany</button>
	</div>
</form>
