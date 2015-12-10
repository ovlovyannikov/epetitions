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
        <div class="col-md-8 text-center">ЕЛЕКТРОННА ПЕТИЦІЯ № {{ $petition->num }}</div>
                <div class="col-lg-8">
                  <div class="petition">
                      <p class="navbar-custom">СУТЬ ЗВЕРНЕННЯ:</p>
                      <p><b>{{ $petition->title }}</b></h3>
                      <br />
                      <p><span class="navbar-custom">АВТОР:</span> {{ $petition->author }}</p>
                      <p><span class="navbar-custom">СТАТУС:</span> {{ $petition->status_name }}</p>
                      <p><span class="navbar-custom">ДАТА ПОЧАТКУ ЗБОРУ ПІДПИСІВ:</span> {{ $petition->created_at }}</p>
                      <br />
                      <p class="navbar-custom">ТЕКСТ ЕЛЕКТРОННОЇ ПИТИЦІЇ:</p>
                      <p><b>{{ $petition->body }}</b></p>
                      <p><span class="navbar-custom">ЗАГАЛЬНА КІЛЬКІСТЬ ОСІБ, ЯКІ ПІДПИСАЛИ ЕЛЕКТРОННУ ПЕТИЦІЮ: </span><b>{{ $petition->count_signs }}</b></p>
                  </div>
                </div>
        </div>
  </body>
</html>
