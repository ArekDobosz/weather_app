<form action="#" method="POST">
	{{ csrf_field() }}

	<div class="form-group col-md-3">
		<label for="max_temp">Temperatura powyżej</label>
		<input type="number" name="max_temp" min="-50" max="50" step="3" value="" class="form-control">
	</div>
	<div class="form-group col-md-3">
		<label for="max_temp">Temperatura poniżej</label>
		<input type="number" name="min_temp" min="-50" max="50" step="3" value="" class="form-control">
	</div>
	<div class="form-group col-md-3">
		<label for="max_temp">Promieniowanie</label>
		<input type="number" name="min_temp" min="0" max="11" step="1" value="" class="form-control">
	</div>
	<div class="form-group col-md-3">
		<label for="max_temp">Wilgotność powyżej</label>
		<input type="number" name="min_temp" min="0" max="100" step="5" value="" class="form-control">
	</div>
	<div class="form-group col-md-3">
		<label for="max_temp">Wilgotność poniżej</label>
		<input type="number" name="min_temp" min="900" max="100" step="5" value="" class="form-control">
	</div>
	<div class="form-group col-md-3">
		<label for="max_temp">Siła wiatru</label>
		<input type="number" name="wind_v" min="0" max="200" step="10" value="" class="form-control">
	</div>
	<div class="form-group col-md-6">
		<label for="max_temp">Adres e-mail</label>
		<input type="email" name="email" value="" class="form-control">
	</div>
	<div class="col-md-6 pull-right">
		<label></label>
		<button type="button" class="btn btn-info btn-block">Zapisz zmiany</button>
	</div>
</form>
