<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Print Table</title>
		<meta charset="UTF-8" />
		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link href="{{ mix('css/app.css') }}" rel="stylesheet" />
		<style>
			body {
				margin: 20px;
			}
		</style>
	</head>
	<script>
		window.print()
	</script>
	<body>
		<table class="table table-sm">
			@foreach($data as $row) @if ($loop->first)
			<tr>
				@foreach($row as $key => $value)
				<th>{!! $key !!}</th>
				@endforeach
			</tr>
			@endif
			<tr>
				@foreach($row as $key => $value) @if(is_string($value) || is_numeric($value))
				<td>{!! $value !!}</td>
				@else
				<td></td>
				@endif @endforeach
			</tr>
			@endforeach
		</table>
	</body>
</html>
