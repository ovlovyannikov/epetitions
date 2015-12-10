@extends('templates.default')

@section('content')

<div class="row">
  <div class="col-sm-6 col-md-4">

      <div class="caption">
        <img class="media-object center-block" width=48px height=48px src="{{{ asset('img/petition.png') }}}" >
        <h2 class="text-center">1. Подай петицію</h2>
        <p>Перед тим, як створити свою петицію, обов’язково
        <a href="{{ route('auth.signup') }}">зареєструйтеся</a>.
        А також ознайомтесь з <a href="{{ route('petition.petrules') }}">Правилами розгляду громадських ініціатив жителів м.Бердянська з використанням інтернет-ресурсу</a>.
      </p>
      </div>

  </div>
  <div class="col-sm-6 col-md-4">

      <div class="caption">
        <img class="media-object center-block" width=48px height=48px src="{{{ asset('img/add_sign.png') }}}" >
        <h2 class="text-center">2. Збери 250 підписів</h2>
        <p>Якщо ви підтримуєте петицію, обов’язково поставте власний підпис.
        Лише тоді, коли петиція матиме 250 голосів, вона переходить від пропозиції
        до конкретного рішення міської влади. Підписати петицію громадянин
        може вказавши достовірні дані про себе.</p>
      </div>

  </div>
  <div class="col-sm-6 col-md-4">

      <div class="caption">
        <img class="media-object center-block" width=48px height=48px src="{{{ asset('img/gov.png') }}}" >
        <h2 class="text-center">3. Розгляд петиції</h2>
        <p>Петиція, що набрала 250 голосів, протягом {{ env('DAYS_REVIEW') }} днів, підлягає обов’язковому розгляду та наданню відповіді згідно з Законом України "Про звернення громадян".</p>
      </div>

  </div>

</div>

@if(Auth::check())
	<div class="row">
		<p class="text-center"><a class="btn btn-primary btn-lg" href="{{ route('petition.add') }}" role="button"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Написати петицію</a></p>
	</div>
@endif

<h2>Електронні петиції</h2>

<div class="row">

  <div class="col-lg-6 col-md-6 col-sm-12 sorting">
      <ul class="nav nav-pills">
        <li class={{ Request::segment(2) === '1' ? 'active'  : null }}><a href={{ route('petition.index', ['statusId' => 1, 'order' => ! Request::segment(4) ? 'desc' : Request::segment(4)]) }}>ТРИВАЄ ЗБІР ПІДПИСІВ <span class="badge">{{ $pets_by_status->s_1 }}</a></li>
        <li class={{ Request::segment(2) === '2' ? 'active'  : null }}><a href={{ route('petition.index', ['statusId' => 2, 'order' => ! Request::segment(4) ? 'desc' : Request::segment(4)]) }}>НА РОЗГЛЯДІ <span class="badge">{{ $pets_by_status->s_2 }}</a></li>
        <li class={{ Request::segment(2) === '3' ? 'active'  : null }}><a href={{ route('petition.index', ['statusId' => 3, 'order' => ! Request::segment(4) ? 'desc' : Request::segment(4)]) }}>З ВІДПОВІДДЮ <span class="badge">{{ $pets_by_status->s_3 }}</a></li>
      </ul>
  </div>

  <div class="col-lg-6 col-md-6 col-sm-12 sorting">
    <ul class="nav nav-pills pull-right">
      <li class={{ Request::segment(4) === 'desc' ? 'active'  : null }} role="button"><a href={{ route('petition.index', ['statusId' => ! Request::segment(2) ? 1 : Request::segment(2) , 'order' => 'desc']) }}>Спочатку найпопулярніші</a>
      <li class={{ Request::segment(4) === 'asc' ? 'active'  : null }} role="button"><a href={{ route('petition.index', ['statusId' => ! Request::segment(2) ? 1 : Request::segment(2), 'order' => 'asc']) }}>Спочатку найновіші</a>
    </ul>
  </div>

</div>

  @include('petition.partials.tablepet')

@stop
