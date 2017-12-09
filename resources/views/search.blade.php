<form action="#" method="GET" class="form-inline">
	{{ csrf_field() }}
	<div class="col-md-12 text-center">
		<div class="form-group col-md-9 text-right">
			<input type="text" name="city" class="form-control" placeholder="Wyszukaj miasto...">
		</div>
		<div class="col-md-3 text-left">				
			<button id="submit_btn" type="submit" class="btn btn-info">Wyszukaj</button>
		</div>
	</div>
</form>