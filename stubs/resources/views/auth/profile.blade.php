@extends('layouts.dashboard') @section('content')
<div class="container-fluid p-0">
	<h4 class="mb-3">Profile</h4>

	<div class="row">
		<div class="col-md-12">
			<div class="card">
        <div class="card-header"><h5>Details</h5></div>
				<div class="card-body">
					<form id="form-admin-user" action="{{ route('profile.update', $user) }}" method="POST">
						@csrf @method('PUT')
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
									<input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" id="role-{{ $role->id }}" @if($user->hasAnyRole($role->name)) checked @endif disabled />
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

      <div class="card">
        <div class="card-header"><h5>Security Information</h5></div>
				<div class="card-body">
					<form id="form-profile-password" action="{{ route('profile.updatePassword', $user) }}" method="POST">
						@csrf @method('PUT')
						<div class="mb-3 row">
							<x-label for="current_password" value="Current Password" />
							<div class="col-sm-6">
								<x-input type="password" name="current_password" id="current_password" />
							</div>
						</div>
            <div class="mb-3 row">
							<x-label for="new_password" value="New Password" />
							<div class="col-sm-6">
								<x-input type="password" name="new_password" id="new_password" />
							</div>
						</div>
            <div class="mb-3 row">
							<x-label for="new_password_confirmation" value="Verify New Password" />
							<div class="col-sm-6">
								<x-input type="password" name="new_password_confirmation" id="new_password_confirmation" />
							</div>
						</div>
					</form>
				</div>
				<div class="card-footer justify-content-end">
					<a href="{{ url()->previous() }}" class="btn btn-outline-primary me-2">Cancel</a>
					<button type="submit" form="form-profile-password" class="btn btn-primary">Save</button>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
