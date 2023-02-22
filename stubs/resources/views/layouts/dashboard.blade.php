<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @stack('styles')

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
    <script>
        $(document).on('change', '.navigator', function (e) {
            if($(this).val()) {
                $(location).prop('href', $(this).val());
            }
        });
    </script>
    @stack('scripts')
</head>
<body>

	<div class="wrapper">
		<x-sidebar />

		<div class="main">
			<x-navbar />

			<main class="content position-relative">
                @yield('content')
                <x-toast class="position-absolute top-0 end-0" :errors="$errors" :success="session('success')" :status="session('status')" :failed="session('failed')"  />
			</main>
		</div>
	</div>
</body>
    @stack('belowscripts')
</html>

