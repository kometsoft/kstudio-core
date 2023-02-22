@extends('layouts.dashboard') @section('content')
<div class="container-fluid p-0">
	<h4 class="mb-3">{{ $role->exists ? "Role - $role->name" : "Create Role" }}</h4>

	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<form id="form-admin-role" action="{{ $role->exists ? route('admin.role.update', $role) : route('admin.role.store') }}" method="POST">
						@csrf @method($role->exists ? 'PUT' : 'POST')
						<div class="mb-3 row">
							<x-label for="name" value="Name" />
							<div class="col-sm-10">
								<x-input type="text" name="name" id="name" :value="$role->name" required />
							</div>
						</div>
						<div class="mb-3 row">
							<x-label for="guard_name" value="Guard Name" />
							<div class="col-sm-10">
								<x-input type="text" name="guard_name" id="guard_name" :value="$role->guard_name" required />
							</div>
						</div>
						<div class="mb-3 row">
							<x-label for="permissions" value="Permissions" />
							<div class="col-sm-10">
								@foreach($permissions as $permission)
								<div class="form-check">
									<input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission-{{ $permission->id }}" @if($role->hasAnyPermission($permission->name)) checked @endif />
									<label class="form-check-label" for="permission-{{ $permission->id }}">{{ $permission->name }}</label>
								</div>
								@endforeach
							</div>
						</div>
					</form>
				</div>
				<div class="card-footer justify-content-end">
					<a href="{{ url()->previous() }}" class="btn btn-outline-primary me-2">Cancel</a>
					<button type="submit" form="form-admin-role" class="btn btn-primary">Save</button>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
