@extends('layouts.dashboard') @section('content')
<div class="container-fluid p-0">
	<x-page-header>
		<h3>{{ __('Data Dictionaries') }}</h3>
		<a href="{{ route('admin.data-dictionary.create') }}" class="btn btn-primary">Create</a>
	</x-page-header>

	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					{{ $dataTable->table([], true) }}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection @push('scripts')
<script>
	$(function(){
		{{ $dataTable->javascripts() }}
	})
</script>
@endpush
