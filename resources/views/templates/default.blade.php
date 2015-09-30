<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Бердянська петиція</title>
		<link rel="icon" href="{{{ asset('css/theme.blue.css') }}}">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
		<link rel="icon" href="{{{ asset('favicon.png') }}}">
	</head>
	<body>
		@include('templates.partials.navigation')
		<div class="container">
			@include('templates.partials.alerts')
			@yield('content')
		</div>
		<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="{{ asset('js/jquery.tablesorter.min.js') }}"></script>
		<script src="{{ asset('js/jquery.tablesorter.widgets.js') }}"></script>
		<script>
			$(document).ready(function(){
				$(function(){
						$("#table_petition").tablesorter({});
				});
			});
		</script>
	</body>
</html>
