@extends('layouts.dashboard') @section('content')
<div class="container-fluid p-0">
	<h4 class="mb-3">{{ $lookup->exists ? "Lookup - $lookup->key" : "Create Data Dictionary" }}</h4>

	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<form id="form-admin-user" action="{{ $lookup->exists ? route('admin.data-dictionary.update', $lookup) : route('admin.data-dictionary.store') }}" method="POST">
						@csrf @method($lookup->exists ? 'PUT' : 'POST')
						
						@if(Request::segment(3) === 'create')
						<div class="mb-3 row">
							<x-label for="new_existing" value="New Key or Existing Key?" />
							<div class="col-sm-10 mt-3">
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="key_type" id="" value="new">
									<label class="form-check-label" for="inlineRadio1">New</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="key_type" id="" value="existing">
									<label class="form-check-label" for="inlineRadio2">Existing</label>
								</div>
							</div>
						</div>
						@endif
						<div class="mb-3 row">
							<x-label for="key" value="Key" />
							<div class="col-sm-10" id="show">
								@if (Request::segment(4) === 'edit')
									<x-input type="text" name="key" id="key" :value="$lookup->key" required />
								@endif
							</div>
						</div>
						<div class="mb-3 row">
							<x-label for="parent_key" value="Parent Key" />
							<div class="col-sm-10">
								<input type="hidden" id="_parent_id" value="{{ data_get($lookup, 'parent_id') }}">

								<select class="form-select" name="parent_key" id="parent_key">
									<option value="0" selected> Default (Parent)</option>
									@foreach ($keys as $key)
										<option value="{{ $key->key }}" @if($key->key == data_get($lookup, 'parent_key')) selected @endif> {{ $key->key }} </option>
									@endforeach									
								</select>
							</div>
						</div>
						<div class="mb-3 row">
							<x-label for="parent_id" value="Parent ID" />
							<div class="col-sm-10">
								{{-- <x-input type="text" name="parent_id" id="parent_id" :value="$lookup->parent_id" required /> --}}

								<select class="form-select" name="parent_id" id="parent_id" >
									<option value="0" selected> Default (Parent)</option>
								
								</select>
							</div>
						</div>
						<div class="mb-3 row">
							<x-label for="code" value="Code" />
							<div class="col-sm-10">
								<x-input type="text" name="code" id="code" :value="$lookup->code" required />
							</div>
						</div>
						<div class="mb-3 row">
							<x-label for="value_local" value="Value" />
							<div class="col-sm-10">
								<x-input type="text" name="value_local" id="value_local" :value="$lookup->value_local" required />
							</div>
						</div>
						<div class="mb-3 row">
							<x-label for="value_translation" value="Translation" />
							<div class="col-sm-10">
								<x-textarea type="text" name="value_translation" id="value_translation" :value="$lookup->value_translation" required />
							</div>
						</div>
						<div class="mb-3 row">
							<x-label for="description" value="Description" />
							<div class="col-sm-10">
								<x-textarea type="text" name="description" id="description" :value="$lookup->description" required />
							</div>
						</div>
						<div class="mb-3 row">
							<x-label for="is_active" value="Active" />
							<div class="col-sm-10 d-flex align-items-center">
								<x-checkbox name="is_active" id="is_active" :value="$lookup->is_active ?? true" required :options="lookup_yes_no()"/>
							</div>
						</div>
					</form>
				</div>
				<div class="card-footer justify-content-end">
					<a href="{{ url()->previous() }}" class="btn btn-outline-primary me-2">Cancel</a>
					<button type="submit" form="form-admin-user" class="btn btn-primary">Save</button>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
	<script>
		$(document).on('change', '#parent_key', function(e){
			e.preventDefault();

			var key = $('#parent_key').val();

			$.ajax({
				url: "/admin/data-dictionary/getKey/" + key +"",
				type:'GET',
				data: {key:key},
				success: function(data) {
					$('#parent_id').empty();
					$('#parent_id').append('<option value="">{{ __('Default (Parent)') }}</option>');

					$.each(data,function(index,value){
						$('#parent_id').append('<option value="'+value.id+'">'+value.value_local+'</option>');
					});

					setTimeout(() => {
						$('#parent_id').val($('#_parent_id').val()).trigger('change');
					}, 1000);
				}
			});
		}); 

		$(document).ready(function(){
			$('input[name=key_type]').on('change', function(){
			var n = $(this).val();
			switch(n)
				{
					case 'new':
						$('#show').html(`<x-input type="text" name="key" id="key" :value="$lookup->key" required />`);
						break;
					case 'existing':
						$('#show').html(`<select class="form-select" name="key">
									@foreach ($keys as $key)
										<option value="{{ $key->key }}" @if($key->key == data_get($lookup, 'parent_id')) selected @endif> {{ $key->key }} </option>
									@endforeach									
								</select>`);
						break;
				}
			});

			$('#parent_key').trigger('change');
		});
	</script>
@endpush
