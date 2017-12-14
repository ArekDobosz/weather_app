<form action="#" method="GET" class="form-inline">
	{{ csrf_field() }}
	<div class="col-md-12 col-lg-8">
		<input type="text" name="city" class="form-control" placeholder="Wyszukaj miasto...">
		
	</div>
	<div class="col-md-12 col-lg-4">
		
	<button id="submit_btn" type="submit" class="btn btn-info btn-block">Pokaż pogodę</button>
	</div>
</form>