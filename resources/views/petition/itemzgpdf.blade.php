<!DOCTYPE html>
<html>
	<head>
		  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
			<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
			<style> body { font-family: DejaVu Sans, sans-serif; } </style>
	</head>
	<body>
      <div class="row">
        <div class="col-md-8 text-center">ЗВЕРНЕННЯ ГРОМАДЯН</div>
                <div class="col-lg-8">
                  <div class="petition">
                      <p class="navbar-custom">СУТЬ ЗВЕРНЕННЯ:</p>
                      <p><b>{{ $petition->title }}</b></h3>
                      <br />
                      <p><span class="navbar-custom">АВТОР:</span> {{ $petition->author }} (моб.телефон: {{ $petition->phone }}; ел.пошта: {{ $petition->email }})</p>
                      <br />
                      <p class="navbar-custom">ТЕКСТ ЗВЕРНЕННЯ:</p>
                      <p><b>{{ $petition->body }}</b></p>
                  </div>
                </div>
        </div>
  </body>
</html>
