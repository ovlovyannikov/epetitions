@extends('templates.default')

@section('content')
			<h3>Оновлення профілю</h3>
			<div class="row">
							<div class="col-lg-6">
											<form class="form-vertical" role="form" method="post" action"{{ route('profile.edit') }}">
															<div class="row">
																			<div class="col-lg-4">
																							<div class="form-group{{ $errors->has('first_name') ? ' has-error': '' }}">
																											<label for="first_name" class="control-label">Прізвище</label>
																											<input type="text" name="first_name" class="form-control" id="first_name"
																											value="{{ Request::old('first_name') ?: Auth::user()->first_name }}">
																											@if ($errors->has('first_name'))
																												<span class="help_block">{{ $errors->first('first_name') }}</span>
																											@endif
																							</div>
																			</div>

																			<div class="col-lg-4">
																							<div class="form-group{{ $errors->has('middle_name') ? ' has-error': '' }}">
																											<label for="middle_name" class="control-label">Ім’я</label>
																											<input type="text" name="middle_name" class="form-control" id="middle_name"
																											value="{{ Request::old('middle_name') ?: Auth::user()->middle_name }}">
																											@if ($errors->has('middle_name'))
																												<span class="help_block">{{ $errors->first('middle_name') }}</span>
																											@endif
																							</div>
																			</div>

																			<div class="col-lg-4">
																							<div class="form-group{{ $errors->has('last_name') ? ' has-error': '' }}">
																											<label for="last_name" class="control-label">По батькові</label>
																											<input type="text" name="last_name" class="form-control" id="last_name"
																											value="{{ Request::old('last_name') ?: Auth::user()->last_name }}">
																											@if ($errors->has('last_name'))
																												<span class="help_block">{{ $errors->first('last_name') }}</span>
																											@endif
																							</div>
																			</div>
															</div>

															<div class="row">
																			<div class="col-lg-12">
																					<div class="form-group{{ $errors->has('email') ? ' has-error': '' }}">
																								<label for="email" class="control-label">Електронна пошта</label>
																								<input type="text" name="email" class="form-control" id="email"
																								value="{{ Request::old('email') ?: Auth::user()->email }}">
																								@if ($errors->has('email'))
																									<span class="help_block">{{ $errors->first('email') }}</span>
																								@endif
																				</div>
																			</div>

															</div>

															<div class="form-group">
																			<button tupe="submit" class="btn btn-default">Оновити</button>
															</div>
															<input type="hidden" name="_token" value="{{ Session::token() }}">
											</form>
							</div>
			</div>
@stop
