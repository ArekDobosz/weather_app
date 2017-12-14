@if(session()->has('msg.status'))
	<div class="alert alert-{{ session('msg.status') }} text-center">{{ session('msg.content') }}</div>
@endif
<div class="panel panel-success">
	<div class="panel-heading text-center">
		<h4>Twoje powiadomienia dla <span id="myCity">{{ $user->place->name }}</span></h4>		
	</div>
	<div class="panel-body">
		<form action="{{ url('preferences/'. $user->token) }}" method="POST" novalidate="">

			{{ csrf_field() }}
			{{ method_field('PATCH') }}

			<div class="form-group col-md-4 {{ $errors->has('max_temp') ? 'has-error' : '' }}">
				<label for="max_temp">Temperatura powyżej</label>
				<input type="number" name="max_temp" min="-50" max="50" step="3" value="{{ $user->max_temp }}" class="form-control">
                <div class="help-block">
					@if($errors->has('max_temp'))
                        {{ $errors->first('max_temp') }}
                    @endif
                </div>
			</div>
			<div class="form-group col-md-4 {{ $errors->has('min_temp') ? 'has-error' : '' }}">
				<label for="min_temp">Temperatura poniżej</label>
				<input type="number" name="min_temp" min="-50" max="50" step="3" value="{{ $user->min_temp }}" class="form-control">
				<div class="help-block">
					@if($errors->has('min_temp'))
                        {{ $errors->first('min_temp') }}
                    @endif
                </div>
			</div>
			<div class="form-group col-md-4 {{ $errors->has('radiation') ? 'has-error' : '' }}">
				<label for="radiation">Promieniowanie</label>
				<input type="number" name="radiation" min="0" max="11" step="1" value="{{ $user->radiation }}" class="form-control">
				<div class="help-block">
					@if($errors->has('radiation'))
                        {{ $errors->first('radiation') }}
                    @endif
                </div>
			</div>
			<div class="form-group col-md-4 {{ $errors->has('max_humidity') ? 'has-error' : '' }}">
				<label for="max_humidity">Wilgotność powyżej</label>
				<input type="number" name="max_humidity" min="0" max="100" step="5" value="{{ $user->max_humidity }}" class="form-control">
				<div class="help-block">
					@if($errors->has('max_humidity'))
                        {{ $errors->first('max_humidity') }}
                    @endif
                </div>
			</div>
			<div class="form-group col-md-4 {{ $errors->has('min_humidity') ? 'has-error' : '' }}">
				<label for="min_humidity">Wilgotność poniżej</label>
				<input type="number" name="min_humidity" min="0" max="100" step="5" value="{{ $user->min_humidity }}" class="form-control">
				<div class="help-block">
					@if($errors->has('min_humidity'))
                        {{ $errors->first('min_humidity') }}
                    @endif
                </div>
			</div>
			<div class="form-group col-md-4 {{ $errors->has('wind') ? 'has-error' : '' }}">
				<label for="wind">Siła wiatru</label>
				<input type="number" name="wind" min="0" max="200" step="10" value="{{ $user->wind }}" class="form-control">
				<div class="help-block">
					@if($errors->has('wind'))
                        {{ $errors->first('wind') }}
                    @endif
                </div>
			</div>
			<input type="hidden" name="cityName" value="">
			<input type="hidden" name="lat" value="">
			<input type="hidden" name="lng" value="">
			<div class="col-md-4 pull-right">
				<label></label>
				<button type="submit" class="btn btn-info btn-block">Zapisz zmiany</button>
			</div>
		</form>
	</div>
</div>
