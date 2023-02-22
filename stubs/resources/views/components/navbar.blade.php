<nav class="navbar navbar-expand navbar-light navbar-bg">
	<a class="sidebar-toggle js-sidebar-toggle">
		<i class="ti ti-menu-2 align-self-center"></i>
	</a>

	<div class="navbar-collapse collapse">
		<ul class="navbar-nav navbar-align">
			<!-- <li class="nav-item dropdown">
				<a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
					<div class="position-relative">
						<i class="ti ti-bell"></i>
						<span class="indicator">4</span>
					</div>
				</a>
				<div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
					<div class="dropdown-menu-header">4 New Notifications</div>
					<div class="list-group">
						<a href="#" class="list-group-item">
							<div class="row g-0 align-items-center">
								<div class="col-2">
									<i class="ti ti-alert-circle text-danger"></i>
								</div>
								<div class="col-10">
									<div class="text-dark">Update completed</div>
									<div class="text-muted small mt-1">Restart server 12 to complete the update.</div>
									<div class="text-muted small mt-1">30m ago</div>
								</div>
							</div>
						</a>
						<a href="#" class="list-group-item">
							<div class="row g-0 align-items-center">
								<div class="col-2">
									<i class="ti ti-bell text-warning"></i>
								</div>
								<div class="col-10">
									<div class="text-dark">Lorem ipsum</div>
									<div class="text-muted small mt-1">Aliquam ex eros, imperdiet vulputate hendrerit et.</div>
									<div class="text-muted small mt-1">2h ago</div>
								</div>
							</div>
						</a>
					</div>
					<div class="dropdown-menu-footer">
						<a href="#" class="text-muted">Show all notifications</a>
					</div>
				</div>
			</li> -->
			<!-- <li class="nav-item dropdown d-none d-sm-inline-block">
				<a href="#" class="nav-icon" onclick="toggleFullscreen()">
					<i class="ti ti-maximize"></i>
				</a>
			</li> -->
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
					<span class="text-dark me-2">{{ Auth::user()->name }}</span>
					<img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&color=7F9CF5&background=EBF4FF" class="avatar img-fluid rounded" alt="{{ Auth::user()->name }}" />
				</a>
				<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
					<i class="ti ti-dots-vertical"></i>
				</a>
				<div class="dropdown-menu dropdown-menu-end">
					<a class="dropdown-item" href="{{ route('profile.index') }}"><i class="ti ti-user align-middle text-primary me-2"></i> Profile</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <i class="ti ti-logout align-middle text-primary me-2"></i> {{ __('Logout') }} </a>
					<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
				</div>
			</li>
		</ul>
	</div>
</nav>
