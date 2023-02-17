@extends('layouts.dashboard') @section('content')
<div class="container-fluid p-0">
	<x-page-header>
		<h3>Edit Menu Management</h3>
	</x-page-header>

	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<form id="create-menu" action="{{ route('menu.update') }}" method="post">
						@csrf

						<x-page-header>
							<h5>Menu</h5>
							<div>
								<button type="button" class="btn btn-sm btn-outline-primary" id="add-menu">+ Menu</button>
							</div>
						</x-page-header>

						<div id="menu">
							{{-- MENU --}}
							@foreach ($menus as $menu)
							<div class="menu my-1" id="submenu{{ $menu['id'] }}">
								<div class="d-flex justify-content-between align-items-center">
									<div class="col-md-9">
										<div class="input-group">
											<span class="input-group-text">Menu</span>
											<input type="hidden" name="menu[{{  $menu['id'] }}][type]" value="menu">
											<input type="hidden" name="menu[{{  $menu['id'] }}][parent_id]" value="{{ $menu['parent_id'] }}" id="getid{{ $menu['id'] }}">
											<input type="hidden" name="menu[{{  $menu['id'] }}][id]" value="{{ $menu['id'] }}">
											<input type="text" name="menu[{{  $menu['id'] }}][menu]" value="{{ $menu['menu'] }}" class="form-control" placeholder="Title" aria-label="Title" id="menuTitle{{ $menu['id'] }}">
											<span class="input-group-text">
												<button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#menuModal{{  $menu['id'] }}">
													<i class="ti ti-settings fs-6"></i>
												</button>
											</span>
										</div>
									</div>
									<div>
										<button type="button" class="btn btn-sm btn-outline-primary me-2" id="add-submenu-edit{{ $menu['id'] }}">+ Sub-Menu</button>
										<button type="button" class="btn btn-sm btn-danger remove-menu">
											<i class="ti ti-trash fs-6"></i>
										</button>
									</div>
								</div>

								{{-- MENU:MODAL --}}
								<div class="modal fade" id="menuModal{{  $menu['id'] }}" tabindex="-1" aria-labelledby="menuModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="menuModalLabel">Menu: </h5>
												<h5 class="modal-title" id="modalTitle{{ $menu['id'] }}">{{ $menu['menu'] }}</h5>
												<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
											</div>
											<div class="modal-body">
												<div class="mb-3 row">
													<label for="label" class="col-sm-2 col-form-label">Icon</label>
													<div class="col-sm-6">
														<input type="text" class="form-control" name="menu[{{  $menu['id'] }}][icon]" placeholder="Eg: ti ti-user" value="{{ $menu['icon'] }}">
													</div>
													<div class="col-sm-4 mt-2">
														<a href="https://tabler-icons.io/" class="" target="_blank">List of Icon</a>
													</div>
												</div>
												<div class="mb-3 row">
													<label for="label" class="col-sm-2 col-form-label">URL</label>
													<div class="col-sm-6">
														<select class="form-select" name="menu[{{$menu['id'] }}][url]" aria-label="">
															<option value="">Choose route</option>
															@if (!empty($formRoutes))
															@foreach ($formRoutes as $formRoute)
															<option value="{{ $formRoute['route'] }}" @if ($formRoute['route']==$menu['url']) selected @endif>{{ $formRoute['name'] }}</option>
															@endforeach
															@endif
															@if (!empty($calendars))
															@foreach ($calendars as $calendar)
															<option value="calendar.view,{{ $calendar->id }}" @if ($menu['url']==="calendar.view,$calendar->id" ) selected @endif>Calendar - {{ $calendar['name'] }}</option>
															@endforeach
															@endif
														</select>
													</div>
												</div>
												<div class="mb-3 row">
													<label for="label" class="col-sm-2 col-form-label">Permission</label>
													<div class="col-sm-6 mt-2">
														@foreach ($permissions as $permission)
														<div class="form-check">
															@php
															$_permission = $menu['permission'] ?? [];
															$_checked = '';

															if (!empty($_permission)) {
															$_checked = collect(\Arr::where($_permission, function ($value, $key) use ($permission) {
															return $permission->name == $value;
															}))->count() > 0 ? 'checked' : '';
															}
															@endphp
															<input class="form-check-input" type="checkbox" value="{{ $permission->name }}" {{ $_checked ?? '' }} name="menu[{{ $menu['id'] }}][permission][]">
															<label class="form-check-label">
																{{ $permission->name }}
															</label>
														</div>
														@endforeach
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Confirm</button>
											</div>
										</div>
									</div>
								</div>
								{{-- MENU:MODAL --}}


								{{-- SUBMENU --}}
								@foreach ($submenus->where('parent_id', $menu['id']) as $sub)

								<div class="submenu my-2 ms-5">
									<div class="d-flex justify-content-between align-items-center">
										<div class="col-md-10">
											<div class="input-group">
												<span class="input-group-text">Sub-Menu</span>
												<input type="hidden" name="menu[{{ $sub['id'] }}][type]" value="submenu">
												<input type="hidden" name="menu[{{  $sub['id'] }}][parent_id]" value="{{ $sub['parent_id'] }}">
												<input type="hidden" name="menu[{{ $sub['id'] }}][id]" value="{{ $sub['id'] }}">
												<input type="text" name="menu[{{ $sub['id'] }}][menu]" value="{{ $sub['menu'] }}" class="form-control" placeholder="Title" aria-label="Title" id="submenuTitle{{ $sub['id'] }}">
												<span class="input-group-text">
													<button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#submenuModal{{ $sub['id'] }}">
														<i class="ti ti-settings fs-6"></i>
													</button>
												</span>
											</div>
										</div>
										<button type="button" class="btn btn-sm btn-danger remove-submenu">
											<i class="ti ti-trash fs-6"></i>
										</button>
									</div>
								</div>

								{{-- SUBMENU:MODAL --}}
								<div class="modal fade" id="submenuModal{{ $sub['id'] }}" tabindex="-1" aria-labelledby="submenuModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="submenuModalLabel">Sub-Menu: </h5>
												<h5 class="modal-title" id="modalSubTitle{{ $sub['id'] }}">{{ $sub['menu'] }}</h5>
												<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
											</div>
											<div class="modal-body">
												<div class="mb-3 row">
													<label for="label" class="col-sm-2 col-form-label">Icon</label>
													<div class="col-sm-6">
														<input type="text" class="form-control" name="menu[{{ $sub['id'] }}][icon]" placeholder="Eg: ti ti-user" value="{{ $sub['icon'] }}">
													</div>
													<div class="col-sm-4 mt-2">
														<a href="https://tabler-icons.io/" class="" target="_blank">List of Icon</a>
													</div>
												</div>
												<div class="mb-3 row">
													<label for="label" class="col-sm-2 col-form-label">URL</label>
													<div class="col-sm-6">
														<select class="form-select" name="menu[{{ $sub['id'] }}][url]" aria-label="">
															<option value="">Choose route</option>
															@if (!empty($formRoutes))
															@foreach ($formRoutes as $formRoute)
															<option value="{{ $formRoute['route'] }}" @if ($formRoute['route']==$sub['url']) selected @endif>{{ $formRoute['name'] }}</option>
															@endforeach
															@endif
															@if (!empty($calendars))
															@foreach ($calendars as $calendar)
															<option value="calendar.view,{{ $calendar->id }}" @if ($sub['url']==="calendar.view,$calendar->id" ) selected @endif>Calendar - {{ $calendar['name'] }}</option>
															@endforeach
															@endif
														</select>
													</div>
												</div>
												<div class="mb-3 row">
													<label for="label" class="col-sm-2 col-form-label">Permission</label>
													<div class="col-sm-6 mt-2">
														@foreach ($permissions as $permission)
														<div class="form-check">
															@php
															$_permission = $sub['permission'] ?? [];
															$_checked = '';

															if (!empty($_permission)) {
															$_checked = collect(\Arr::where($_permission, function ($value, $key) use ($permission) {
															return $permission->name == $value;
															}))->count() > 0 ? 'checked' : '';
															}
															@endphp
															<input class="form-check-input" type="checkbox" value="{{ $permission->name }}" {{ $_checked ?? '' }} name="menu[{{ $sub['id'] }}][permission][]">
															<label class="form-check-label">
																{{ $permission->name }}
															</label>
														</div>
														@endforeach
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Confirm</button>
											</div>
										</div>
									</div>
								</div>
								{{-- SUBMENU:MODAL --}}

								@endforeach
								{{-- SUBMENU --}}

							</div>
							@endforeach
							{{-- MENU --}}
						</div>


						<div id="modalMenu">

						</div>

						<div id="modalSubMenu">

						</div>

					</form>
					<div class="card-footer justify-content-end">
						<a href="{{ url()->previous() }}" class="btn btn-outline-primary me-2">Cancel</a>
						<button type="submit" form="create-menu" class="btn btn-primary">Save</button>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

@endsection
@push('scripts')
<script>
	// MENU
	$(document).ready(function () {
		var menus = @json($menus);
		Object.keys(menus).forEach(key => {
			$(document).ready(function () {
				$(`#menuTitle${menus[key]['id']}`).on("input", function () {
					// Print entered value in a Modal
					$(`#modalTitle${menus[key]['id']}`).text($(this).val());
				});
			});
		});
	});
	// SUBTITLE
	$(document).ready(function () {
		var submenus = @json($submenus);
		Object.keys(submenus).forEach(key => {
			$(document).ready(function () {
				$(`#submenuTitle${submenus[key]['id']}`).on("input", function () {
					// Print entered value in a Modal
					$(`#modalSubTitle${submenus[key]['id']}`).text($(this).val());
				});
			});
		});
	});
</script>
@endpush
@push('belowscripts')
<script>
	var i = {{ $countMenu }} + {{ $countSubMenu }};
	// var j = {{ $countSubMenu }}
	// ADD MENU
	$("#add-menu").click(function () {
		i++;

		$("#menu").append(`<div class="menu my-1" id="submenu${i}">
							<div class="d-flex justify-content-between align-items-center">
								<div class="col-md-9">
									<div class="input-group">
										<span class="input-group-text">Menu</span>
										<input type="hidden" name="menu[${i}][type]" value="menu">
										<input type="hidden" name="menu[${i}][parent_id]" value="${i}" id="getid${i}">
										<input type="hidden" name="menu[${i}][id]" value="${i}" >
										<input type="text" name="menu[${i}][menu]" class="form-control" placeholder="Title" aria-label="Title" id="menuTitle${i}">
										<span class="input-group-text">
											<button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#menuModal${i}">
												<i class="ti ti-settings fs-6"></i>
											</button>
										</span>
									</div>
								</div>
								<div>
									<button type="button" class="btn btn-sm btn-outline-primary me-2"
										id="add-submenu${i}">+ Sub-Menu</button>
									<button type="button" class="btn btn-sm btn-danger remove-menu">
										<i class="ti ti-trash fs-6"></i>
									</button>
								</div>
							</div>
						</div>`);

		$('head').append(`<script>
				$(document).ready(function(){
					$("#menuTitle${i}").on("input", function(){
						// Print entered value in a Modal
						$("#modalTitle${i}").text($(this).val());
					});
				});
			<\/script>`);

		$("#modalMenu").append(`<div class="modal fade" id="menuModal${i}" tabindex="-1" aria-labelledby="menuModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg">
										<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="menuModalLabel">Menu: </h5> <h5 class="modal-title" id="modalTitle${i}"></h5>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<div class="modal-body">
											<div class="mb-3 row">
												<label for="label" class="col-sm-2 col-form-label">Icon</label>
												<div class="col-sm-6">
												<input type="text" class="form-control" name="menu[${i}][icon]" placeholder="Eg: ti ti-user">
												</div>
												<div class="col-sm-4 mt-2">
													<a href="https://tabler-icons.io/" class="" target="_blank">List of Icon</a>
												</div>
											</div>
											<div class="mb-3 row">
												<label for="label" class="col-sm-2 col-form-label">URL</label>
												<div class="col-sm-6">
													<select class="form-select" name="menu[${i}][url]" aria-label="">
														<option selected value="">Choose route</option>
														@if (!empty($formRoutes))
															@foreach ($formRoutes as $formRoute)
															<option value="{{ $formRoute['route'] }}">{{ $formRoute['name'] }}</option>
															@endforeach
														@endif
														@if (!empty($calendars))
															@foreach ($calendars as $calendar)
																<option value="calendar.view,{{ $calendar->id }}">Calendar - {{ $calendar['name'] }}</option>
															@endforeach
														@endif
													</select>
												</div>
											</div>
											<div class="mb-3 row">
												<label for="label" class="col-sm-2 col-form-label">Permission</label>
												<div class="col-sm-6 mt-2">
													@foreach ($permissions as $permission)
														<div class="form-check">
															<input class="form-check-input" type="checkbox" value="{{ $permission->name }}" name="menu[${i}][permission][]" >
															<label class="form-check-label" >
																{{ $permission->name }}
															</label>
														</div>
													@endforeach
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Confirm</button>
										</div>
										</div>
									</div>
								</div>`);

		// ADD SUB-MENU
		var button = `#add-submenu${i}`;
		var divname = `#submenu${i}`;
		var getid = `getid${i}`;
		var id = document.getElementById(getid).value;

		$(button).click(function () {
			i++;
			$(divname).append(`<div class="submenu my-2 ms-5">
									<div class="d-flex justify-content-between align-items-center">
										<div class="col-md-10">
											<div class="input-group">
												<span class="input-group-text">Sub-Menu</span>
												<input type="hidden" name="menu[${i}][type]" value="submenu">
												<input type="hidden" name="menu[${i}][parent_id]" value="${id}">
												<input type="hidden" name="menu[${i}][id]" value="${id}-${i}">
												<input type="text" name="menu[${i}][menu]" class="form-control" placeholder="Title" aria-label="Title" id="submenuTitle${i}">
												<span class="input-group-text">
													<button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#submenuModal${i}">
														<i class="ti ti-settings fs-6"></i>
													</button>
												</span>
											</div>
										</div>
										<button type="button" class="btn btn-sm btn-danger remove-submenu">
											<i class="ti ti-trash fs-6"></i>
										</button>
									</div>
								</div>`);

			$('head').append(`<script>
					$(document).ready(function(){
						$("#submenuTitle${i}").on("input", function(){
							// Print entered value in a Modal
							$("#modalSubTitle${i}").text($(this).val());
						});
					});
				<\/script>`);


			$("#modalSubMenu").append(`<div class="modal fade" id="submenuModal${i}" tabindex="-1" aria-labelledby="submenuModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg">
										<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="submenuModalLabel">Sub-Menu: </h5> <h5 class="modal-title" id="modalSubTitle${i}"></h5>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<div class="modal-body">
											<div class="mb-3 row">
												<label for="label" class="col-sm-2 col-form-label">Icon</label>
												<div class="col-sm-6">
												<input type="text" class="form-control" name="menu[${i}][icon]" placeholder="Eg: ti ti-user">
												</div>
												<div class="col-sm-4 mt-2">
													<a href="https://tabler-icons.io/" class="" target="_blank">List of Icon</a>
												</div>
											</div>
											<div class="mb-3 row">
												<label for="label" class="col-sm-2 col-form-label">URL</label>
												<div class="col-sm-6">
													<select class="form-select" name="menu[${i}][url]" aria-label="">
														<option selected value="">Choose route</option>
														@if (!empty($formRoutes))
															@foreach ($formRoutes as $formRoute)
															<option value="{{ $formRoute['route'] }}">{{ $formRoute['name'] }}</option>
															@endforeach
														@endif
														@if (!empty($calendars))
															@foreach ($calendars as $calendar)
																<option value="calendar.view,{{ $calendar->id }}">Calendar - {{ $calendar['name'] }}</option>
															@endforeach
														@endif
													</select>
												</div>
											</div>
											<div class="mb-3 row">
												<label for="label" class="col-sm-2 col-form-label">Permission</label>
												<div class="col-sm-6 mt-2">
													@foreach ($permissions as $permission)
														<div class="form-check">
															<input class="form-check-input" type="checkbox" value="{{ $permission->name }}" name="menu[${i}][permission][]">
															<label class="form-check-label">
																{{ $permission->name }}
															</label>
														</div>
													@endforeach
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Confirm</button>
										</div>
										</div>
									</div>
								</div>`);
		});

	});

	// REMOVE MENU
	$(document).on('click', '.remove-menu', function () {
		$(this).parents('.menu').remove();
	});

	// REMOVE SUB-MENU
	$(document).on('click', '.remove-submenu', function () {
		$(this).parents('.submenu').remove();
	});

	$(document).ready(function () {
		var menus = @json($menus);
		var n = 100;
		Object.keys(menus).forEach(key => {
			// console.log(menus[key]['id']); 
			// ADD SUB-MENU
			var menubutton = `#add-submenu-edit${menus[key]['id']}`;
			var menudiv = `#submenu${menus[key]['id']}`;
			$(menubutton).click(function () {
				n++;
				$(menudiv).append(`<div class="submenu my-2 ms-5">
									<div class="d-flex justify-content-between align-items-center">
										<div class="col-md-10">
											<div class="input-group">
												<span class="input-group-text">Sub-Menu</span>
												<input type="hidden" name="menu[${n}][type]" value="submenu">
												<input type="hidden" name="menu[${n}][parent_id]" value="${menus[key]['id']}">
												<input type="hidden" name="menu[${n}][id]" value="${menus[key]['id']}-${n}">
												<input type="text" name="menu[${n}][menu]" class="form-control" placeholder="Title" aria-label="Title" id="submenuTitle${n}">
												<span class="input-group-text">
													<button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#submenuModal${n}">
														<i class="ti ti-settings fs-6"></i>
													</button>
												</span>
											</div>
										</div>
										<button type="button" class="btn btn-sm btn-danger remove-submenu">
											<i class="ti ti-trash fs-6"></i>
										</button>
									</div>
								</div>`);

				$('head').append(`<script>
									$(document).ready(function(){
										$("#submenuTitle${n}").on("input", function(){
											// Print entered value in a Modal
											$("#modalSubTitle${n}").text($(this).val());
										});
									});
								<\/script>`);


				$("#modalSubMenu").append(`<div class="modal fade" id="submenuModal${n}" tabindex="-1" aria-labelledby="submenuModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg">
										<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="submenuModalLabel">Sub-Menu: </h5> <h5 class="modal-title" id="modalSubTitle${n}"></h5>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<div class="modal-body">
											<div class="mb-3 row">
												<label for="label" class="col-sm-2 col-form-label">Icon</label>
												<div class="col-sm-6">
												<input type="text" class="form-control" name="menu[${n}][icon]" placeholder="Eg: ti ti-user">
												</div>
												<div class="col-sm-4 mt-2">
													<a href="https://tabler-icons.io/" class="" target="_blank">List of Icon</a>
												</div>
											</div>
											<div class="mb-3 row">
												<label for="label" class="col-sm-2 col-form-label">URL</label>
												<div class="col-sm-6">
													<select class="form-select" name="menu[${n}][url]" aria-label="">
														<option selected value="">Choose route</option>
														@if (!empty($formRoutes))
															@foreach ($formRoutes as $formRoute)
															<option value="{{ $formRoute['route'] }}">{{ $formRoute['name'] }}</option>
															@endforeach
														@endif
														@if (!empty($calendars))
															@foreach ($calendars as $calendar)
																<option value="calendar.view,{{ $calendar->id }}">Calendar - {{ $calendar['name'] }}</option>
															@endforeach
														@endif
													</select>
												</div>
											</div>
											<div class="mb-3 row">
												<label for="label" class="col-sm-2 col-form-label">Permission</label>
												<div class="col-sm-6 mt-2">
													@foreach ($permissions as $permission)
														<div class="form-check">
															<input class="form-check-input" type="checkbox" value="{{ $permission->name }}" name="menu[${n}][permission][]">
															<label class="form-check-label">
																{{ $permission->name }}
															</label>
														</div>
													@endforeach
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Confirm</button>
										</div>
										</div>
									</div>
								</div>`);
			});
		});

	});
</script>
@endpush