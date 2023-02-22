@extends('layouts.dashboard') @section('content')
<div class="container-fluid p-0">
	<h4 class="mb-3">{{ $user->exists ? "User - $user->name" : "Create User" }}</h4>

	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<form id="form-admin-user" action="{{ $user->exists ? route('admin.user.update', $user) : route('admin.user.store') }}" method="POST">
						@csrf @method($user->exists ? 'PUT' : 'POST')
						<div class="mb-3 row">
							<x-label for="name" value="Name" />
							<div class="col-sm-10">
								<x-input type="text" name="name" id="name" :value="$user->name" required />
							</div>
						</div>
						<div class="mb-3 row">
							<x-label for="email" value="Email" />
							<div class="col-sm-10">
								<x-input type="text" name="email" id="email" :value="$user->email" required />
							</div>
						</div>
						<div class="mb-3 row">
							<x-label for="roles" value="Roles" />
							<div class="col-sm-10">
								@foreach($roles as $role)
								<div class="form-check">
									<input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" id="role-{{ $role->id }}" @if($user->hasAnyRole($role->name)) checked @endif />
									<label class="form-check-label" for="role-{{ $role->id }}">{{ $role->name }}</label>
								</div>
								@endforeach
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
