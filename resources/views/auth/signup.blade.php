@extends('templates.default')

@section('content')
	<h3>Реєстрація</h3>
	<div class="row">
    <div class="col-lg-6">
        <form class="form-vertical" role="form" method="post" action=" {{ route('auth.signup') }}">

					<div class="row">

									<div class="col-lg-4">
													<div class="form-group{{ $errors->has('first_name') ? ' has-error': '' }}">
																	<label for="first_name" class="control-label">Прізвище</label>
																	<input type="text" name="first_name" class="form-control" id="first_name">
																	@if ($errors->has('first_name'))
																		<span class="help_block">{{ $errors->first('first_name') }}</span>
																	@endif
													</div>
									</div>

									<div class="col-lg-4">
													<div class="form-group{{ $errors->has('middle_name') ? ' has-error': '' }}">
																	<label for="middle_name" class="control-label">Ім’я</label>
																	<input type="text" name="middle_name" class="form-control" id="middle_name">
																	@if ($errors->has('middle_name'))
																		<span class="help_block">{{ $errors->first('middle_name') }}</span>
																	@endif
													</div>
									</div>

									<div class="col-lg-4">
													<div class="form-group{{ $errors->has('last_name') ? ' has-error': '' }}">
																	<label for="last_name" class="control-label">По батькові</label>
																	<input type="text" name="last_name" class="form-control" id="last_name">
																	@if ($errors->has('last_name'))
																		<span class="help_block">{{ $errors->first('last_name') }}</span>
																	@endif
													</div>
									</div>
					</div>
			
			<div class="form-group{{ $errors->has('organization') ? ' has-error' : '' }}">
                <label for="organization" class="control-label">Назва організації (якщо від імені організації)</label>
                <input type="text" name="organization" class="form-control" id="organization" value="{{ Request::old('organization') ?: '' }}">
				@if ($errors->has('organization'))
					<span class="help-block">{{ $errors->first('organization') }}</span>
				@endif
            </div>
					
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="control-label">Електронна пошта</label>
                <input type="text" name="email" class="form-control" id="email" value="{{ Request::old('email') ?: '' }}">
				@if ($errors->has('email'))
					<span class="help-block">{{ $errors->first('email') }}</span>
				@endif
            </div>
			
			<div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                <label for="phone" class="control-label">Мобільний телефон (номер починається з 066,063,050,099 і т.д.)</label>
                <input type="text" name="phone" class="form-control" id="phone" value="{{ Request::old('phone') ?: '' }}">
				@if ($errors->has('phone'))
					<span class="help-block">{{ $errors->first('phone') }}</span>
				@endif
            </div>

			<div class="row">

									<div class="col-lg-6">
											<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
												<label for="password" class="control-label">Пароль</label>
												<input type="password" name="password" class="form-control" id="password" value="{{ Request::old('password') ?: '' }}">
												@if ($errors->has('password'))
													<span class="help-block">{{ $errors->first('password') }}</span>
												@endif
											</div>
									</div>
									
									<div class="col-lg-6">
											<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
												<label for="password_confirm">Пароль ще раз</label>
												<input type="password" id="password_confirm" class="form-control" name="password_confirm">
												@if ($errors->has('password_confirm'))
													<span class="help-block">{{ $errors->first('password_confirm') }}</span>
												@endif
											</div>
									</div>
			</div>

						<label>* Усі поля обов’язкові для заповнення (крім назви організації)</label>

						<div class="checkbox">
														<input type="checkbox" name="pd" id="pd" checked value=1>
														<label for="data">
																Шляхом встановлення цього позначення я, відповідно до Закону України «Про захист персональних даних»,
																надаю згоду виконавчому комітету Бердянської міської ради на обробку моїх
																персональних даних у картотеках та/або за допомогою інформаційно-телекомунікаційної системи
																бази персональних даних виконавчого комітету Бердянської міської з метою ідентифікації користувачів сервісу
																електронних петицій Офіційного інтернет-представництва організації та
																забезпечення дотримання вимог Закону України «Про звернення громадян».
														</label>
						</div>
			
			
			<div class="form-group">
                {!! app('captcha')->display(); !!}
            </div>
			
			
            <div class="form-group">
                <button type="submit" class="btn btn-default">Зареєструватися</button>
            </div>
			<input type="hidden" name="_token" value="{{ Session::token() }}">
        </form>
    </div>
	</div>
@stop
