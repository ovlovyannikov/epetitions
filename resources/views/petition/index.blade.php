@extends('templates.default')

@section('content')
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
