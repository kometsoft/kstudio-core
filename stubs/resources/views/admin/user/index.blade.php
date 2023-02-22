@extends('layouts.dashboard') @section('content')
<div class="container-fluid p-0">
	<x-page-header>
		<h3>Users</h3>
		<a href="{{ route('admin.user.create') }}" class="btn btn-primary">Create</a>
	</x-page-header>

	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					{{ $dataTable->table() }}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script>
$(function(){
	{{ $dataTable->javascripts() }}
})
</script>
@endpush
