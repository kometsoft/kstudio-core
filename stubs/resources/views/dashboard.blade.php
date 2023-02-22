@extends('layouts.dashboard') @section('content')
<!-- <div class="container-fluid p-0">
	<h1 class="h3 mb-3">Dashboard</h1>

	<div class="row">
		<div class="col-xl-6 col-xxl-5 d-flex">
			<div class="w-100">
				<div class="row">
					<div class="col-sm-6">
						<div class="card">
							<div class="card-body">
								<div class="row">
									<div class="col mt-0">
										<h5 class="card-title">Sales</h5>
									</div>

									<div class="col-auto">
										<div class="stat text-primary">
											<i class="ti ti-truck-delivery align-middle"></i>
										</div>
									</div>
								</div>
								<h1 class="mt-1 mb-3">2.382</h1>
								<div class="mb-0">
									<span class="text-danger">-3.65%</span>
									<span class="text-muted">Since last week</span>
								</div>
							</div>
						</div>
						<div class="card">
							<div class="card-body">
								<div class="row">
									<div class="col mt-0">
										<h5 class="card-title">Visitors</h5>
									</div>

									<div class="col-auto">
										<div class="stat text-primary">
											<i class="ti ti-users align-middle"></i>
										</div>
									</div>
								</div>
								<h1 class="mt-1 mb-3">14.212</h1>
								<div class="mb-0">
									<span class="text-success">5.25%</span>
									<span class="text-muted">Since last week</span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="card">
							<div class="card-body">
								<div class="row">
									<div class="col mt-0">
										<h5 class="card-title">Earnings</h5>
									</div>

									<div class="col-auto">
										<div class="stat text-primary">
											<i class="ti ti-currency-dollar align-middle"></i>
										</div>
									</div>
								</div>
								<h1 class="mt-1 mb-3">$21.300</h1>
								<div class="mb-0">
									<span class="text-success">6.65%</span>
									<span class="text-muted">Since last week</span>
								</div>
							</div>
						</div>
						<div class="card">
							<div class="card-body">
								<div class="row">
									<div class="col mt-0">
										<h5 class="card-title">Orders</h5>
									</div>

									<div class="col-auto">
										<div class="stat text-primary">
											<i class="ti ti-shopping-cart align-middle"></i>
										</div>
									</div>
								</div>
								<h1 class="mt-1 mb-3">64</h1>
								<div class="mb-0">
									<span class="text-danger">-2.25%</span>
									<span class="text-muted">Since last week</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-6 col-xxl-7">
			<div class="card flex-fill w-100">
				<div class="card-header">
					<h5 class="card-title mb-0">Recent Movement</h5>
				</div>
				<div class="card-body py-3">
					<div class="chart chart-sm">
						<canvas id="chartjs-dashboard-line"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> -->
<div class="container-fluid p-0">
	<h1 class="h3 mb-3">Dashboard</h1>

	<div class="row">
		<div class="col-xl-6 col-xxl-5 d-flex">
			<div class="w-100">
				<div class="row">
					<div class="col-sm-6">
						<div class="card">
							<div class="card-body">
								<div class="row">
									<div class="col mt-0">
										<h5 class="card-title">Sales</h5>
									</div>

									<div class="col-auto">
										<div class="stat text-primary">
											<i class="ti ti-truck-delivery align-middle"></i>
										</div>
									</div>
								</div>
								<h1 class="mt-1 mb-3">2.382</h1>
								<div class="mb-0">
									<span class="text-danger">-3.65%</span>
									<span class="text-muted">Since last week</span>
								</div>
							</div>
						</div>
						<div class="card">
							<div class="card-body">
								<div class="row">
									<div class="col mt-0">
										<h5 class="card-title">Visitors</h5>
									</div>

									<div class="col-auto">
										<div class="stat text-primary">
											<i class="ti ti-users align-middle"></i>
										</div>
									</div>
								</div>
								<h1 class="mt-1 mb-3">14.212</h1>
								<div class="mb-0">
									<span class="text-success">5.25%</span>
									<span class="text-muted">Since last week</span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="card">
							<div class="card-body">
								<div class="row">
									<div class="col mt-0">
										<h5 class="card-title">Earnings</h5>
									</div>

									<div class="col-auto">
										<div class="stat text-primary">
											<i class="ti ti-currency-dollar align-middle"></i>
										</div>
									</div>
								</div>
								<h1 class="mt-1 mb-3">RM21.300</h1>
								<div class="mb-0">
									<span class="text-success">6.65%</span>
									<span class="text-muted">Since last week</span>
								</div>
							</div>
						</div>
						<div class="card">
							<div class="card-body">
								<div class="row">
									<div class="col mt-0">
										<h5 class="card-title">Orders</h5>
									</div>

									<div class="col-auto">
										<div class="stat text-primary">
											<i class="ti ti-shopping-cart align-middle"></i>
										</div>
									</div>
								</div>
								<h1 class="mt-1 mb-3">64</h1>
								<div class="mb-0">
									<span class="text-danger">-2.25%</span>
									<span class="text-muted">Since last week</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-6 col-xxl-7">
			<div class="card flex-fill w-100">
				<div class="card-header">
					<h5 class="card-title mb-0">Recent Movement</h5>
				</div>
				<div class="card-body py-3">
					<div class="chart chart-sm">
						<canvas id="chartjs-dashboard-line"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-12 col-md-3 col-xxl-3 d-flex order-2 order-xxl-3">
			<div class="card flex-fill w-100">
				<div class="card-header">
					<h5 class="card-title mb-0">Browser Usage</h5>
				</div>
				<div class="card-body d-flex">
					<div class="align-self-center w-100">
						<div class="py-3">
							<div class="chart chart-xs">
								<canvas id="chartjs-dashboard-pie"></canvas>
							</div>
						</div>

						<table class="table mb-0">
							<tbody>
								<tr>
									<td>Chrome</td>
									<td class="text-end">4306</td>
								</tr>
								<tr>
									<td>Firefox</td>
									<td class="text-end">3801</td>
								</tr>
								<tr>
									<td>IE</td>
									<td class="text-end">1689</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-12 col-xxl-3 d-flex order-3 order-xxl-2">
			<div class="card flex-fill w-100">
				<div class="card-header">
					<h5 class="card-title mb-0">Monthly Growth</h5>
				</div>
				<div class="card-body d-flex w-100">
					<div class="align-self-center chart chart-lg">
						<canvas id="chartjs-dashboard-bar"></canvas>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-lg-12 col-xxl-6 d-flex">
			<div class="card flex-fill">
				<div class="card-header">
					<h5 class="card-title mb-0">Latest Projects</h5>
				</div>
				<div class="card-body">
					<table class="table table-hover my-0">
						<thead>
							<tr>
								<th>Name</th>
								<th class="d-none d-xl-table-cell">Start Date</th>
								<th class="d-none d-xl-table-cell">End Date</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Project Apollo</td>
								<td class="d-none d-xl-table-cell">01/01/2021</td>
								<td class="d-none d-xl-table-cell">31/06/2021</td>
								<td><span class="badge bg-success">Done</span></td>
							</tr>
							<tr>
								<td>Project Fireball</td>
								<td class="d-none d-xl-table-cell">01/01/2021</td>
								<td class="d-none d-xl-table-cell">31/06/2021</td>
								<td><span class="badge bg-danger">Cancelled</span></td>
							</tr>
							<tr>
								<td>Project Hades</td>
								<td class="d-none d-xl-table-cell">01/01/2021</td>
								<td class="d-none d-xl-table-cell">31/06/2021</td>
								<td><span class="badge bg-success">Done</span></td>
							</tr>
							<tr>
								<td>Project Nitro</td>
								<td class="d-none d-xl-table-cell">01/01/2021</td>
								<td class="d-none d-xl-table-cell">31/06/2021</td>
								<td><span class="badge bg-warning">In progress</span></td>
							</tr>
							<tr>
								<td>Project Phoenix</td>
								<td class="d-none d-xl-table-cell">01/01/2021</td>
								<td class="d-none d-xl-table-cell">31/06/2021</td>
								<td><span class="badge bg-success">Done</span></td>
							</tr>
							<tr>
								<td>Project X</td>
								<td class="d-none d-xl-table-cell">01/01/2021</td>
								<td class="d-none d-xl-table-cell">31/06/2021</td>
								<td><span class="badge bg-success">Done</span></td>
							</tr>
							<tr>
								<td>Project Romeo</td>
								<td class="d-none d-xl-table-cell">01/01/2021</td>
								<td class="d-none d-xl-table-cell">31/06/2021</td>
								<td><span class="badge bg-success">Done</span></td>
							</tr>
							<tr>
								<td>Project Wombat</td>
								<td class="d-none d-xl-table-cell">01/01/2021</td>
								<td class="d-none d-xl-table-cell">31/06/2021</td>
								<td><span class="badge bg-warning">In progress</span></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script>
	$(function(){
		var ctx = document.getElementById('chartjs-dashboard-line').getContext('2d')
		var gradient = ctx.createLinearGradient(0, 0, 0, 225)
		gradient.addColorStop(0, 'rgba(37, 99, 235, 1)')
		gradient.addColorStop(1, 'rgba(37, 99, 235, 0)')
		// Line chart
		new Chart(document.getElementById('chartjs-dashboard-line'), {
			type: 'line',
			data: {
				labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
				datasets: [
					{
						label: 'Sales ($)',
						fill: true,
						backgroundColor: gradient,
						borderColor: window.theme.primary,
						data: [2115, 1562, 1584, 1892, 1587, 1923, 2566, 2448, 2805, 3438, 2917, 3327],
					},
				],
			},
			options: {
				maintainAspectRatio: false,
				legend: {
					display: false,
				},
				tooltips: {
					intersect: false,
				},
				hover: {
					intersect: true,
				},
				plugins: {
					filler: {
						propagate: false,
					},
				},
				scales: {
					xAxes: [
						{
							reverse: true,
							gridLines: {
								color: 'rgba(0,0,0,0.0)',
							},
						},
					],
					yAxes: [
						{
							ticks: {
								stepSize: 1000,
							},
							display: true,
							borderDash: [3, 3],
							gridLines: {
								color: 'rgba(0,0,0,0.0)',
							},
						},
					],
				},
			},
		})
	})
</script>
<script>
	$(function(){
		// Pie chart
		new Chart(document.getElementById('chartjs-dashboard-pie'), {
			type: 'pie',
			data: {
				labels: ['Chrome', 'Firefox', 'IE'],
				datasets: [
					{
						data: [4306, 3801, 1689],
						backgroundColor: [window.theme.primary, window.theme.warning, window.theme.danger],
						borderWidth: 5,
					},
				],
			},
			options: {
				responsive: !window.MSInputMethodContext,
				maintainAspectRatio: false,
				legend: {
					display: false,
				},
				cutoutPercentage: 75,
			},
		})
	})
</script>
<script>
	$(function(){
		// Bar chart
		new Chart(document.getElementById('chartjs-dashboard-bar'), {
			type: 'bar',
			data: {
				labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
				datasets: [
					{
						label: 'This year',
						backgroundColor: window.theme.primary,
						borderColor: window.theme.primary,
						hoverBackgroundColor: window.theme.primary,
						hoverBorderColor: window.theme.primary,
						data: [54, 67, 41, 55, 62, 45, 55, 73, 60, 76, 48, 79],
						barPercentage: 0.75,
						categoryPercentage: 0.5,
					},
				],
			},
			options: {
				maintainAspectRatio: false,
				legend: {
					display: false,
				},
				scales: {
					yAxes: [
						{
							gridLines: {
								display: false,
							},
							stacked: false,
							ticks: {
								stepSize: 20,
							},
						},
					],
					xAxes: [
						{
							stacked: false,
							gridLines: {
								color: 'transparent',
							},
						},
					],
				},
			},
		})
	})
</script>

@endpush
