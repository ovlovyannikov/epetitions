@extends('templates.default')

@section('content')
	<h3>Додати петицію</h3>
	<div class="row">
    <div class="col-lg-6">
        <form class="form-vertical" role="form" method="post" action=" {{ route('petition.add') }}">

				<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                <label for="title" class="control-label">Суть звернення</label>
                <input type="text" name="title" class="form-control" id="title">
				@if ($errors->has('title'))
					<span class="help-block">{{ $errors->first('title') }}</span>
				@endif
            </div>


            <div class="form-group{{ $errors->has('') ? ' has-error' : '' }}">
                <label for="body" class="control-label">Текст петиції</label>
                <textarea name="body" class="form-control" rows="6"
										placeholder="Текст петиції" id="body">
								</textarea>
				@if ($errors->has('body'))
					<span class="help-block">{{ $errors->first('body') }}</span>
				@endif
            </div>

			
			<!--<div class="form-group">
                {!! app('captcha')->display(); !!}
            </div>-->
			

            <div class="form-group">
                <button type="submit" class="btn btn-default">Додати</button>
            </div>

			<input type="hidden" name="_token" value="{{ Session::token() }}">
        </form>
    </div>
	</div>
@stop
