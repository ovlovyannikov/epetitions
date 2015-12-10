@extends('templates.default')

@section('content')
<div class="row">
      <div class="col-lg-8">
        <div class="petition">
			<p><span class="navbar-custom">РЕЄСТРАЦІЙНИЙ НОМЕР:</span> {{ $petition->num }}</p>
            <p class="navbar-custom">СУТЬ ЗВЕРНЕННЯ:</p>
            <h3 class="petition_title" style="margin-top: 10px;">{{ $petition->title }}</h3>
            <br />
            <p><span class="navbar-custom">АВТОР:</span> {{ $petition->author }} @role('moderator') (моб.телефон: {{ $petition->phone }}; ел.пошта: {{ $petition->email }}) @endrole</p>
            <p><span class="navbar-custom">СТАТУС:</span> {{ $petition->status_name }}</p>
            <p><span class="navbar-custom">ДАТА ПОЧАТКУ ЗБОРУ ПІДПИСІВ:</span> {{ $petition->created_at }}</p>
            <br />
            <p class="navbar-custom">ТЕКСТ ЕЛЕКТРОННОЇ ПИТИЦІЇ:</p>
            <p>{{ $petition->body }}</p>
            <br />
            @if($petition->answer)
                <p class="navbar-custom">ВІДПОВІДЬ:</p>
                <p>{!! $petition->answer !!}</p>
                <br />
            @endif
            <p class="navbar-custom">ПЕРЕЛІК ОСІБ, ЯКІ ПІДПИСАЛИ ЕЛЕКТРОННУ ПЕТИЦІЮ:</p>
            <ul>
              @foreach ($signs as $sign)
                <li>{{ $sign->author }} (дата підпису: {{ $sign->created_at }}@role('moderator'); моб.телефон: {{ $sign->phone }}; ел.пошта: {{ $sign->email }}
                      <a href="{{ route('petition.delsign', ['signId' => $sign->sign_id]) }}">видалити</a> @endrole)

                </li>
              @endforeach
            <ul>
        </div>
      </div>

      <div class="col-lg-4">
            <p class="text-center navbar-custom">ЗАГАЛЬНА КІЛЬКІСТЬ ОСІБ, ЯКІ ПІДПИСАЛИ ЕЛЕКТРОННУ ПЕТИЦІЮ:</p>
            <h3 class="text-center petition_body" style="margin-top: 10px;">{{ $petition->count_signs }} з 250 необхідних</h3>

            <p class="text-center navbar-custom">ДО КІНЦЯ ЗБОРУ ПІДПИСІВ ЗАЛИШИЛОСЯ (ДНІВ):</p>
            <h3 class="text-center petition_days" style="margin-top: 10px;">{{ $petition->days }}</h3>

              @if(!Auth::check())
                <div class="text-center alert alert-danger" role="alert">
                  Для того, щоб підтримати петицію, необхідно
                  <a href="{{ route('auth.signin') }}">авторизуватися</a>.
                </div>
              @else
                  <p class="text-center navbar-custom">ПІДТРИМАТИ ЕЛЕКТРОННУ ПЕТИЦІЮ:</p>

        					  @if (Auth::user()->hasPetSignUser($petition->id, Auth::user()->id))
        						  <div class="text-center alert alert-success" role="alert">
        								Ви вже підтримали цю петицію.
        						  </div>
        					  @else
        						  <p class="text-center">
        							  <a href="{{ route('petition.sign', ['petitionId' => $petition->id]) }}"
        								class="btn btn-primary btn-lg active" role="button">ПІДПИСАТИ</a>
        						  </p>
        					  @endif
              @endif

              <p>
                <p>Поділитися:</p>
                  <span class='st_facebook_large' displayText='Facebook'></span>
                  <span class='st_vkontakte_large' displayText='Vkontakte'></span>
                  <span class='st_twitter_large' displayText='Tweet'></span>
                  <span class='st_googleplus_large' displayText='Google +'></span>
              </p>

              <p>
                @role('moderator')

                  <a href="{{ route('petition.pdf', ['petitionId' => $petition->id]) }}"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> PDF </a>
                  <a href="{{ route('petition.pdfzg', ['petitionId' => $petition->id]) }}"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> PDF (ЗГ)</a>

                  <p class="text-center navbar-custom">ПЕРЕВІРКА МОДЕРАТОРОМ:</p>
                  <form class="form-vertical" role="form" method="post" action"{{ route('petition.item' , ['petitionId' => $petition->id]) }}">

                      <div class="form-group{{ $errors->has('checked') ? ' has-error' : '' }}">
                              <label for="checked" class="control-label">Перевірено</label>
                              <input type="text" name="checked" class="form-control" id="checked"
                              value="{{ Request::old('checked') ?: $petition->checked }}" >
              				@if ($errors->has('checked'))
              					<span class="help-block">{{ $errors->first('checked') }}</span>
              				@endif
                      </div>

                      <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                              <label for="status" class="control-label">Статус</label>
                              <input type="text" name="status" class="form-control" id="status"
                              value="{{ Request::old('status') ?: $petition->status }}" >
                      @if ($errors->has('status'))
                        <span class="help-block">{{ $errors->first('status') }}</span>
                      @endif
                      </div>

                      <div class="form-group{{ $errors->has('done') ? ' has-error' : '' }}">
                              <label for="done" class="control-label">Виконано</label>
                              <input type="text" name="done" class="form-control" id="done"
                              value="{{ Request::old('done') ?: $petition->done }}" >
                      @if ($errors->has('done'))
                        <span class="help-block">{{ $errors->first('done') }}</span>
                      @endif
                      </div>

                    <div class="form-group{{ $errors->has('answer') ? ' has-error' : '' }}">
                              <label for="answer" class="control-label">Відповідь</label>
                              <textarea type="text" name="answer" class="form-control" rows="6"
              										placeholder="Текст петиції" id="answer"
                                  value="{{ Request::old('answer') ? '' : $petition->answer }}">
              								</textarea>
              				@if ($errors->has('answer'))
              					<span class="help-block">{{ $errors->first('answer') }}</span>
              				@endif
                    </div>

                    <div class="form-group">
                            <button tupe="submit" class="btn btn-default">Оновити</button>
                    </div>
                    <input type="hidden" name="_token" value="{{ Session::token() }}">

                  </form>
                @endrole
              </p>

      </div>
</div>
@stop
