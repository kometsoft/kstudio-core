@extends('layouts.dashboard') @section('content')
<div class="container-fluid p-0">
	<x-page-header>
		<h3>Edit List</h3>
	</x-page-header>

	<div class="row">
		<div class="col-md-12">
			<div class="card">

				<div class="card-header">
					<h5>List</h5>
				</div>
				<div class="card-body">

					<form id="update-list" action="{{route('list.update', $list->id)}}" method="post">
						@csrf

						<div class="mb-3 row">
							<x-label for="name" value="List Name" />
							<div class="col-sm-10">
								<x-input type="text" name="name" id="name" value="{{ $list->name }}" />
							</div>
						</div>
						<div class="mb-3 row">
							<x-label for="description" value="Description" />
							<div class="col-sm-10">
								<textarea class="form-control" name="description" id="description" cols="30" rows="3">{{ $list->description }}</textarea>
							</div>
						</div>
						<div class="mb-3 row">
							<x-label for="name" value="Model" />
							<input type="hidden" name="model" id="model" value="{{ $list->settings['model'] }}">
							<div class="col-sm-10">
								<select class="form-select model-used" name="table" id="model-input">
									@foreach ($models as $model)
									<option value="{{ $model['model'] }}" @if($list->settings['model'] == $model['model']) selected @endif>{{ $model['model'] }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="mb-3">
							<div>
								<x-label for="condition" value="Conditions" />
								<button type="button" class="btn btn-sm btn-primary col-sm-2 float-end" id="add-condition"><i class="ti ti-plus align-middle"></i> <span class="align-middle">Condition</span></button>
							</div>
							@foreach ($list->settings['conditions'] as $val)
							<div class="row condition-div">
								<x-label for="" value="" />

								<div class="col-sm-10 row ">
									<div class="col-sm-3">
										<small><label class="form-label">Column</label></small>
										<select class="form-select column" id="column" name="condition[{{ $loop->iteration }}][column]">
											@foreach ($columns as $column)
											<option value="{{ $column['column_name'] }}" @if ($val['column']==$column['column_name']) selected @endif> {{ $column['column_name'] }}</option>
											@endforeach
										</select>
									</div>
									<div class="col-sm-3">
										<small><label class="form-label">Condition</label></small>
										<select class="form-select" name="condition[{{ $loop->iteration }}][condition]">
											@foreach ($conditions as $condition)
											<option value="{{ $condition['value'] }}" @if ($val['condition']==$condition['value']) selected @endif> {{ $condition['type'] }}</option>
											@endforeach
										</select>
									</div>
									<div class="col-sm-5">
										<small><label class="form-label">Value</label></small>
										<input type="text" class="form-control" name="condition[{{ $loop->iteration }}][value]" value="{{ $val['value'] }}">
									</div>
									<div class="col-sm-1 mt-3 pt-2">
										<button class="btn btn-md btn-danger remove-condition"><i class="ti ti-trash align-middle"></i></button>
									</div>
								</div>
							</div>
							@endforeach

							<div id="condition">

							</div>

						</div>
						<div class="mb-3 row">
							<x-label for="indexList" value="Index List" />
							<div class="col-sm-10">
								<div class="mb-3 row">
									<label for="" class="col-sm-3 col-form-label">Number of Item / Page</label>
									<div class="col-sm-2">
										<input class="form-control" type="number" name="item_per_page" value="{{ $list->settings['indexList']['item_per_page'] }}">
									</div>
								</div>
								<table class="table" id="model-list">
									<thead>
										<tr>
											<th scope="col">Model Name</th>
											<th scope="col">Field Name</th>
											<th scope="col">Field to Display</th>
											<th scope="col">Field for Filter</th>
										</tr>
									</thead>
									<tbody id="model-body">
										@foreach ( $list->settings['indexList']['list_properties'] as $column)
										<tr>
											<th>{{ $list->settings['model'] }}</th>
											<td>{{ $column['field_name'] }}
												<input type="hidden" name="list[{{ $loop->iteration }}][field_name]" value="{{ $column['field_name'] }}">
											</td>
											<td>
												<div class="form-check"><input class="" type="hidden" name="list[{{ $loop->iteration }}][field_display]" value="No"><input class="form-check-input" name="list[{{ $loop->iteration }}][field_display]" type="checkbox" value="Yes" @if( $column['field_display']=='Yes' ) checked @endif></div>
											</td>
											<td>
												<div class="form-check"><input class="" type="hidden" name="list[{{ $loop->iteration }}][field_filter]" value="No"><input class="form-check-input" name="list[{{ $loop->iteration }}][field_filter]" type="checkbox" value="Yes" @if( $column['field_filter']=='Yes' ) checked @endif></div>
											</td>
										</tr>
										@endforeach
									</tbody>

								</table>
							</div>
						</div>
					</form>
					<div class="card-footer justify-content-end">
						<a href="{{ url()->previous() }}" class="btn btn-outline-primary me-2">Cancel</a>
						<button type="submit" form="update-list" class="btn btn-primary">Update</button>
					</div>

				</div>
			</div>
		</div>
	</div>

</div>

@endsection

@push('belowscripts')
<script>
	// single Table
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

						var k = {
							{
								$total
							}
						};
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

	var i = {
		{
			$total
		}
	};
	$("#add-condition").click(function () {
		i++;

		$("#condition").append(`<div class="row condition-div">
									<x-label for="" value="" />

									<div class="col-sm-10 row" >
										<div class="col-sm-3">
											<small><label  class="form-label">Column</label></small>
											<select class="form-select column" id="column${i}" name="condition[${i}][column]">
												@foreach ($columns as $column)
													<option value="{{ $column['column_name'] }}"> {{ $column['column_name'] }}</option>
												@endforeach
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