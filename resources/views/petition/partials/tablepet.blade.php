<table id="table_petition" class="table table-striped">
    <thead>
      <tr>
        <th class="navbar-custom">Суть звернення</th>
        <th class="text-center navbar-custom">Залишилося днів</th>
        <th class="text-center navbar-custom">Зібрано підписів</th>
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
{!! $petitions->render() !!}
