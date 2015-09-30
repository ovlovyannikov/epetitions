@extends('templates.default')

@section('content')

<div class="row">
  <div class="col-sm-6 col-md-4">

      <div class="caption">
        <img class="media-object center-block" width=48px height=48px src="{{{ asset('img/petition.png') }}}" >
        <h2 class="text-center">1. Подай петицію</h2>
        <p>Перед тим як створити свою петицію обов’язково
        <a href="{{ route('auth.signup') }}">зареєструйся</a>.
        А також ознайомтесь з <a href="{{ route('petition.petrules') }}">Правилами розгляду громадських ініціатив жителів
        м.Бердянська з використанням інтернет-ресурсу</a>.
      </p>
      </div>

  </div>
  <div class="col-sm-6 col-md-4">

      <div class="caption">
        <img class="media-object center-block" width=48px height=48px src="{{{ asset('img/add_sign.png') }}}" >
        <h2 class="text-center">2. Збери 200 підписів</h2>
        <p>Якщо ви підтримуєте петицію, обов’язково поставте власний підпис.
        Лише тоді, коли петиція матиме 200 голосів вона переходить від пропозиції
        до конкретного рішення міської влади. Підписати петицію громадянин
        може, вказавши електронну адресу та достовірні дані про себе.</p>
      </div>

  </div>
  <div class="col-sm-6 col-md-4">

      <div class="caption">
        <img class="media-object center-block" width=48px height=48px src="{{{ asset('img/gov.png') }}}" >
        <h2 class="text-center">3. Розляд петиції</h2>
        <p>Петиція, що набрала 200 голосів протягом 30 днів в обов’язковому порядку
        виноситься на розгляд чергової сесії Бердянської міської ради.
        Автор запропонованого запрошується на засідання сесії та отримує право на
        оприлюднення петиції.</p>
      </div>

  </div>

</div>

<h2>Електронні петиції</h2>

  <ul class="nav nav-pills">
    <li role="presentation" ><a href="{{ route('petition.index', ['statusId' => 1]) }}">ТРИВАЄ ЗБІР ПІДПИСІВ</a></li>
    <li role="presentation" ><a href="{{ route('petition.index', ['statusId' => 2])  }}">НА РОЗГЛЯДІ</a></li>
    <li role="presentation" ><a href="{{ route('petition.index', ['statusId' => 3])  }}">З ВІДПОВІДДЮ</a></li>
  </ul>
  <table id="table_petition" class="table table-striped">
    <thead>
      <tr>
        <th>Суть звернення</th>
        <th class="text-center">Залишилося днів</th>
        <th class="text-center">Зібрано підписів</th>
      </tr>
    </thead>
    <tbody>
      	@foreach ($petitions as $petition)
        <tr>
            <td>  <a class="pull-left" href="{{ route('petition.item', [
            'id' => $petition->id ]) }}">{{ $petition->title }}</a></td>
            <td class="text-center">{{ $petition->days}}</td>
            <td class="text-center">{{ $petition->count_signs }}</td>
        </tr>
        @endforeach
    </tbody>
  </table>
@stop
