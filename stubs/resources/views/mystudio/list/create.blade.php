@extends('layouts.dashboard') @section('content')
<div class="container-fluid p-0">
	<x-page-header>
		<h3>Create List</h3>
	</x-page-header>

	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h5>List</h5>
				</div>
				<div class="card-body">
					<form id="create-list" action="{{route('list.store')}}" method="post">
						@csrf
						<div class="mb-3 row">
							<x-label for="name" value="List Name" />
							<div class="col-sm-10">
								<x-input type="text" name="name" id="name" required />
							</div>
						</div>
						<div class="mb-3 row">
							<x-label for="description" value="Description" />
							<div class="col-sm-10">
								<textarea class="form-control" name="description" id="description" cols="30" rows="3"></textarea>
							</div>
						</div>
						<div class="mb-3 row">
							<x-label for="name" value="Model" />
							<input type="hidden" name="model" id="model" value="">
							<div class="col-sm-10">
								<select class="form-select model-used" name="table" id="model-input" required>
									<option value="">Choose Model ..</option>
									@if (!empty($models))
									@foreach ($models as $model)
									<option value="{{ $model['model'] }}">{{ $model['model'] }}</option>
									@endforeach
									@endif
								</select>
							</div>
						</div>
						<div class="mb-3">
							<div>
								<x-label for="condition" value="Conditions" />
								<button type="button" class="btn btn-sm btn-primary col-sm-2 float-end" id="add-condition"><i class="ti ti-plus align-middle"></i> <span class="align-middle">Condition</span></button>
							</div>
							<div class="row">
								<x-label for="" value="" />

								<div class="col-sm-10 row">
									<div class="col-sm-3">
										<small><label class="form-label">Column</label></small>
										<select class="form-select column" id="column" name="condition[0][column]">

										</select>
									</div>
									<div class="col-sm-3">
										<small><label class="form-label">Condition</label></small>
										<select class="form-select" name="condition[0][condition]">
											@foreach ($conditions as $condition)
											<option value="{{ $condition['value'] }}"> {{ $condition['type'] }}</option>
											@endforeach
										</select>
									</div>
									<div class="col-sm-6">
										<small><label class="form-label">Value</label></small>
										<input type="text" class="form-control" name="condition[0][value]">
									</div>
								</div>
							</div>

							<div id="condition">

							</div>

						</div>
						<div class="mb-3 row">
							<x-label for="indexList" value="Index List" />
							<div class="col-sm-10">
								<div class="mb-3 row">
									<label for="" class="col-sm-3 col-form-label">Number of Item / Page</label>
									<div class="col-sm-2">
										<input class="form-control" type="number" name="item_per_page" value="10">
									</div>
								</div>
								<table class="table" id="model-list">
									<thead>
										<tr>
											<th scope="col">Model Name</th>
											<th scope="col">Field Name</th>
											<th scope="col">Field to Display</th>
											<th scope="col">Field to Filter</th>
										</tr>
									</thead>
									<tbody id="model-body">

									</tbody>

								</table>
							</div>
						</div>
					</form>
				</div>
				<div class="card-footer justify-content-end">
					<a href="{{ url()->previous() }}" class="btn btn-outline-primary me-2">Cancel</a>
					<button type="submit" form="create-list" class="btn btn-primary">Save</button>
				</div>
			</div>
		</div>
	</div>

</div>

@endsection

@push('belowscripts')
<script type="text/javascript">
	// list Table
	$(document).ready(function () {
		$(".model-used").change(function (e) {
			e.preventDefault();

			// empty div element
			$("#model-body").html("");

			// get value of model
			var modelValue = $("#model-input").val();

			// get all model data
			var models = @json($models);
			var key = 0;
			models.forEach(model => {
				if (modelValue == model.model) {
					document.getElementById('model').value = model.model;
					var columns = model.columns;
					$(".column").empty();
					columns.forEach(column => {
						key++;
						$("#model-list").append('<tr><th scope="row">' + model.model + '</th><td>' + column.column_name + '<input type="hidden" name="list[' + key + '][field_name]" value="' + column.column_name + '"></td><td><div class="form-check"><input class="" type="hidden" name="list[' + key + '][field_display]" value="No"><input class="form-check-input" name="list[' + key + '][field_display]" type="checkbox" value="Yes"></div></td><td><div class="form-check"><input class="" type="hidden" name="list[' + key + '][field_filter]" value="No"><input class="form-check-input" name="list[' + key + '][field_filter]" type="checkbox" value="Yes"></div></td></tr>');
						$(".column").append('<option value="' + column.column_name + '">' + column.column_name + '</option>');

						var k = 0;
						$("#add-condition").click(function () {
							k++;
							var col = `#column${k}`;
							$(col).append('<option value="' + column.column_name + '">' + column.column_name + '</option>');
						});
					});
				}
			});

		});

	});

	var i = 0;
	$("#add-condition").click(function () {
		i++;

		$("#condition").append(`<div class="row condition-div">
									<x-label for="" value="" />

									<div class="col-sm-10 row" >
										<div class="col-sm-3">
											<small><label  class="form-label">Column</label></small>
											<select class="form-select column" id="column${i}" name="condition[${i}][column]">
												
											</select>
										</div>
										<div class="col-sm-3">
											<small><label  class="form-label">Condition</label></small>
											<select class="form-select" name="condition[${i}][condition]">
												@foreach ($conditions as $condition)
													<option value="{{ $condition['value'] }}"> {{ $condition['type'] }}</option>
												@endforeach
											</select>
										</div>
										<div class="col-sm-5">
											<small><label  class="form-label">Value</label></small>
											<input type="text" class="form-control" name="condition[${i}][value]">
										</div>
										<div class="col-sm-1 mt-3 pt-2">
                                        	<button class="btn btn-md btn-danger remove-condition"><i class="ti ti-trash align-middle"></i></button>
                                    	</div>
									</div>
								</div>`);

	});

	// remove condition
	$(document).on('click', '.remove-condition', function () {
		$(this).parents('.condition-div').remove();
	});
</script>
@endpush